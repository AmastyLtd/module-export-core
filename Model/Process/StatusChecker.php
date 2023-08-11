<?php

declare(strict_types=1);

/**
 * @author Amasty Team
 * @copyright Copyright (c) Amasty (https://www.amasty.com)
 * @package Export Core for Magento 2 (System)
 */

namespace Amasty\ExportCore\Model\Process;

use Amasty\ExportCore\Api\ExportResultInterface;
use Amasty\ExportCore\Model\ConfigProvider;
use Amasty\ExportCore\Processing\JobManager;
use Amasty\ImportExportCore\Api\Process\ProcessStatusInterface;
use Amasty\ImportExportCore\Api\Process\StatusCheckerInterface;
use Amasty\ImportExportCore\Api\Process\ProcessStatusInterfaceFactory;

class StatusChecker implements StatusCheckerInterface
{
    /**
     * @var JobManager
     */
    private $jobManager;

    /**
     * @var ProcessStatusInterfaceFactory
     */
    private $processStatusFactory;

    /**
     * @var ProcessRepository
     */
    private $processRepository;

    public function __construct(
        JobManager $jobManager,
        ProcessStatusInterfaceFactory $processStatusFactory,
        ProcessRepository $processRepository
    ) {
        $this->jobManager = $jobManager;
        $this->processStatusFactory = $processStatusFactory;
        $this->processRepository = $processRepository;
    }

    public function check(string $processIdentity): ProcessStatusInterface
    {
        /**
         * @var Process $process
         * @var ExportResultInterface $exportResult
         */
        [$process, $exportResult] = $this->jobManager->watchJob($processIdentity)->getJobState();
        if ($error = $this->checkError($process, $exportResult)) {
            return $error;
        }

        $processStatus = $this->processStatusFactory->create();
        if ($exportResult === null) {
            $processStatus->setStatus('starting');
            $processStatus->setProceed(0);
            $processStatus->setTotal(0);
            $processStatus->setMessages([
                [
                    'type' => 'info',
                    'message' => __('Process Started')
                ]
            ]);
        } else {
            $processStatus->setStatus($process->getStatus());
            $processStatus->setProceed($exportResult->getRecordsProcessed());
            $processStatus->setTotal($exportResult->getTotalRecords());
            $processStatus->setMessages($exportResult->getMessages());
        }

        return $processStatus;
    }

    private function checkError(Process $process, ?ExportResultInterface $exportResult): ?ProcessStatusInterface
    {
        $isProcessAlive = $process->getPid() !== null
            && $this->jobManager->isPidAlive((int)$process->getPid());
        if (!$isProcessAlive) {
            $currentStatus = $this->processRepository->checkProcessStatus((string)$process->getIdentity());
            $processStatus = $this->processStatusFactory->create();
            if (!$exportResult) { //when error with starting process before first action ran
                $errorMsg = __(
                    'The export process failed to launch. Please, check your PHP executable path or'
                    . ' see log for more details.'
                );
            } elseif (!in_array($currentStatus, [Process::STATUS_SUCCESS, Process::STATUS_FAILED])) {
                $errorMsg = __(
                    'The system process failed. For an error details please make sure that Debug mode is enabled '
                    . 'and see %1',
                    ConfigProvider::DEBUG_LOG_PATH
                );
                $exportResult->logMessage(ExportResultInterface::MESSAGE_CRITICAL, $errorMsg);
            }

            if (isset($errorMsg)) {
                $processStatus->setMessages([
                    [
                        'type' => ExportResultInterface::MESSAGE_CRITICAL,
                        'message' => $errorMsg
                    ]
                ]);

                return $processStatus;
            }
        }

        return null;
    }
}
