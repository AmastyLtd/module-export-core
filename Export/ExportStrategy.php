<?php

declare(strict_types=1);

/**
 * @author Amasty Team
 * @copyright Copyright (c) Amasty (https://www.amasty.com)
 * @package Export Core for Magento 2 (System)
 */

namespace Amasty\ExportCore\Export;

use Amasty\ExportCore\Api\ActionInterface;
use Amasty\ExportCore\Api\Config\ProfileConfigInterface;
use Amasty\ExportCore\Api\ExportProcessInterface;
use Amasty\ExportCore\Api\ExportProcessInterfaceFactory;
use Amasty\ExportCore\Api\ExportResultInterface;
use Amasty\ExportCore\Api\ExportResultInterfaceFactory;
use Amasty\ExportCore\Exception\JobDelegatedException;
use Amasty\ExportCore\Exception\JobDoneException;
use Amasty\ExportCore\Exception\JobTerminatedException;
use Amasty\ExportCore\Export\Config\EntityConfigProvider;
use Amasty\ExportCore\Model\Process\Process;
use Amasty\ImportExportCore\Parallelization\JobManager;
use Amasty\ImportExportCore\Parallelization\JobManagerFactory;
use Amasty\ExportCore\Export\Parallelization\ResultMerger;
use Amasty\ExportCore\Model\ConfigProvider;
use Amasty\ExportCore\Model\Process\ProcessRepository;
use Magento\Framework\App\State;
use Magento\Framework\EntityManager\EventManager;
use Magento\Framework\ObjectManagerInterface;
use Psr\Log\LoggerInterface;

class ExportStrategy
{
    /**
     * @var array
     */
    private $actionGroups;

    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var ExportResultInterfaceFactory
     */
    private $exportResultFactory;

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var ProcessRepository
     */
    private $processRepository;

    /**
     * @var ResultMerger
     */
    private $resultMerger;

    /**
     * @var JobManagerFactory
     */
    private $jobManagerFactory;

    /**
     * @var ExportProcessInterfaceFactory
     */
    private $exportProcessFactory;

    /**
     * @var JobManager
     */
    private $jobManager = null;

    /**
     * @var EntityConfigProvider
     */
    private $entityConfigProvider;

    /**
     * @var State
     */
    private $appState;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var EventManager
     */
    private $eventManager;

    public function __construct(
        ExportResultInterfaceFactory $exportResultFactory,
        EventManager $eventManager,
        ObjectManagerInterface $objectManager,
        ConfigProvider $configProvider,
        ProcessRepository $processRepository,
        JobManagerFactory $jobManagerFactory,
        ResultMerger $resultMerger,
        ExportProcessInterfaceFactory $exportProcessFactory,
        EntityConfigProvider $entityConfigProvider,
        State $appState,
        LoggerInterface $logger,
        array $actionGroups = []
    ) {
        $this->objectManager = $objectManager;
        $this->exportResultFactory = $exportResultFactory;
        $this->configProvider = $configProvider;
        $this->processRepository = $processRepository;
        $this->resultMerger = $resultMerger;
        $this->jobManagerFactory = $jobManagerFactory;
        $this->actionGroups = $actionGroups;
        $this->exportProcessFactory = $exportProcessFactory;
        $this->entityConfigProvider = $entityConfigProvider;
        $this->appState = $appState;
        $this->logger = $logger;
        $this->eventManager = $eventManager;
    }

    public function run(ProfileConfigInterface $profileConfig, string $processIdentity): ExportResultInterface
    {
        $this->processRepository->updateProcessStatusByIdentity($processIdentity, Process::STATUS_STARTING);
        if ($profileConfig->isUseMultiProcess() && JobManager::isAvailable()) {
            $exportProcess = null;
            /** @var JobManager $jobManager */
            $this->jobManager = $this->jobManagerFactory->create([
                'jobDoneCallback' => function ($response) use (&$exportProcess) {
                    $this->processFinalization($exportProcess, $response);
                },
                'maxJobs'         => $profileConfig->getMaxJobs()
            ]);
        } else {
            $this->jobManager = null;
        }

        $exportProcess = $this->exportProcessFactory->create([
            'identity' => $processIdentity,
            'profileConfig' => $profileConfig,
            'entityConfig' => $this->entityConfigProvider->get($profileConfig->getEntityCode()),
            'jobManager' => $this->jobManager
        ]);
        $this->registerErrorCatching($exportProcess);
        $this->eventManager->dispatch('amexport_before_run', ['exportProcess' => $exportProcess]);
        $exportResult = $exportProcess->getExportResult();

        foreach ($this->getSortedActionGroups() as $groupName => $actionsGroup) {
            if (!$exportResult->isExportTerminated()) {
                $exportResult->setStage($groupName);
                $this->processRepository->updateProcess($exportProcess);
            }
            try {
                $actions = $this->prepareActions($actionsGroup, $exportProcess);
                $this->processActions($actions, $exportProcess);
            } catch (JobDoneException $e) {
                return $exportResult;
            } catch (\Exception $e) {
                $exportProcess->addCriticalMessage($e->getMessage());
            } catch (\Throwable $e) {
                    $writer = new \Zend_Log_Writer_Stream(BP .  '/' . ConfigProvider::DEBUG_LOG_PATH);
                    $logger = new \Zend_Log();
                    $logger->addWriter($writer);
                    $logger->info($e->__toString());

                if ($this->configProvider->isDebugEnabled()) {
                    $exportProcess->addCriticalMessage($e->__toString());
                } else {
                    $exportProcess->addCriticalMessage(
                        'An error occurred during the export process. '
                        . 'For the error details please enable \'Debug Mode\' or see the '
                        . ConfigProvider::DEBUG_LOG_PATH
                    );
                }
                $exportProcess->getExportResult()->terminateExport(true);
                break;
            }
        }
        $this->finalizeProcess($exportProcess);

        return $exportResult;
    }

    /**
     * @codeCoverageIgnore Can't be covered by unit/integration tests due to pcntl_fork() usage
     * @param ActionInterface[] $actions
     * @param ExportProcessInterface $exportProcess
     */
    protected function processActions(
        array $actions,
        ExportProcessInterface $exportProcess
    ) {
        $batchIndex = 0;
        do {
            $exportProcess->setData([]);
            $exportProcess->setIsHasNextBatch(false);
            $exportProcess->setCurrentBatchIndex(++$batchIndex);

            try {
                foreach ($actions as $actionCode => $action) {
                    $action->execute($exportProcess);
                    if ($exportProcess->getExportResult()->isExportTerminated()) {
                        break 2;
                    }
                }
            } catch (JobTerminatedException $e) { // Job terminated by some child process. Entire process is failed
                return;
            } catch (JobDelegatedException $e) {
                ;// Another actions from current group should be processed by a child process. Moving to the next batch
            }

            if ($exportProcess->isChildProcess()) {
                $this->jobManager->reportToParent($exportProcess->getExportResult()->serialize());
                throw new JobDoneException();
            }

            $this->processRepository->updateProcess($exportProcess);
        } while ($exportProcess->isHasNextBatch() && !$exportProcess->getExportResult()->isExportTerminated());

        if ($this->jobManager) {
            try {
                $this->jobManager->waitForAllJobs(); // Status updates here
            } catch (JobTerminatedException $e) {
                return;
            }
        }
    }

    /**
     * @codeCoverageIgnore Can't be covered by unit/integration tests due to pcntl_fork() usage
     * @param ExportProcessInterface $exportProcess
     * @param $response
     */
    protected function processFinalization(
        ExportProcessInterface $exportProcess,
        $response
    ) {
        if ($response) {
            $childResult = $this->exportResultFactory->create();
            $childResult->unserialize($response);
            $this->resultMerger->merge($exportProcess->getExportResult(), $childResult);
            $this->processRepository->updateProcess($exportProcess);

            if ($exportProcess->getExportResult()->isFailed()) {
                throw new JobTerminatedException();
            }
        }
    }

    /**
     * @param array $actions
     *
     * @param ExportProcessInterface $exportProcess
     * @return ActionInterface[]
     */
    public function prepareActions(array $actions, ExportProcessInterface $exportProcess): array
    {
        $result = [];

        foreach ($actions as $actionCode => $action) {
            if (empty($action['class'])) {
                continue;
            }
            $class = $action['class'];
            if (!is_subclass_of($class, ActionInterface::class)) {
                throw new \RuntimeException('Wrong action class: "' . $class . '"');
            }

            if (!isset($action['sortOrder'])) {
                throw new \LogicException('"sortOrder" is not specified for action "' . $actionCode . '"');
            }
            $sortOrder = (int)$action['sortOrder'];
            if (!empty($action['entities']) && is_array($action['entities'])) {
                if (!in_array($exportProcess->getProfileConfig()->getEntityCode(), $action['entities'])) {
                    continue;
                }
            }
            unset($action['class'], $action['sortOrder'], $action['entities']);

            if (!isset($result[$sortOrder])) {
                $result[$sortOrder] = [];
            }

            /** @var ActionInterface $actionObject */
            $actionObject = $this->objectManager->create($class, $action);
            $actionObject->initialize($exportProcess);
            $result[$sortOrder][$actionCode] = $actionObject;
        }
        if (empty($result)) {
            return [];
        }

        ksort($result);

        return array_merge(...$result);
    }

    public function getSortedActionGroups(): array
    {
        if (empty($this->actionGroups)) {
            return [];
        }

        $result = [];
        foreach ($this->actionGroups as $groupCode => $groupConfig) {
            if (empty($groupConfig['actions'])) {
                continue;
            }

            if (!isset($groupConfig['sortOrder'])) {
                throw new \LogicException('"sortOrder" is not specified for action group "' . $groupCode . '"');
            }

            $sortOrder = (int)$groupConfig['sortOrder'];
            if (!isset($result[$sortOrder])) {
                $result[$sortOrder] = [];
            }

            unset($groupConfig['sortOrder']);
            $result[$sortOrder][$groupCode] = $groupConfig['actions'];
        }

        if (empty($result)) {
            return [];
        }

        ksort($result);

        return array_merge(...$result);
    }

    public function registerErrorCatching(ExportProcessInterface $exportProcess): ExportStrategy
    {
        //phpcs:ignore
        \register_shutdown_function(function () use ($exportProcess) {
            $currentStatus = $this->processRepository->checkProcessStatus($exportProcess->getIdentity());
            if ($currentStatus === Process::STATUS_SUCCESS || $exportProcess->isChildProcess()) {
                return;
            }
            $errorMsg = __(
                'The system process failed. For an error details please make sure that Debug mode is enabled '
                . 'and see %1',
                ConfigProvider::DEBUG_LOG_PATH
            )->render();

            if ($currentStatus === Process::STATUS_FAILED && $exportProcess->getExportResult() !== null) {
                $hasErrorMessage = false;
                foreach ($exportProcess->getExportResult()->getMessages() as $message) {
                    if (in_array( //error was already processed
                        $message['type'],
                        [ExportResultInterface::MESSAGE_CRITICAL, ExportResultInterface::MESSAGE_ERROR],
                        true
                    )) {
                        $hasErrorMessage = true;
                        break;
                    }
                }
                if ($hasErrorMessage) {
                    $exportProcess->getExportResult()->terminateExport(true);
                    $this->finalizeProcess($exportProcess);

                    return;
                }

                if (error_get_last() !== null && (error_get_last()['type'] ?? null) === 1) {
                    if ($this->appState->getMode() === State::MODE_PRODUCTION) {
                        $errorMsg = __('Something went wrong while export. Please review logs')->render();
                        $this->logger->critical(error_get_last()['message'] ?? '');
                    } else {
                        $errorMsg = error_get_last()['message'] ?? __('Something went wrong while export')->render();
                    }
                }
            }
            $this->processRepository->markAsFailed($exportProcess->getIdentity(), $errorMsg);
        });

        return $this;
    }

    public function finalizeProcess(ExportProcessInterface $exportProcess): ExportStrategy
    {
        $this->eventManager->dispatch('amexport_after_run', ['exportProcess' => $exportProcess]);
        $this->processRepository->finalizeProcess($exportProcess);

        return $this;
    }
}
