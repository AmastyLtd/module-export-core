<?php

namespace Amasty\ExportCore\Controller\Adminhtml\Export;

use Amasty\ExportCore\Api\ExportResultInterface;
use Amasty\ExportCore\Model\ConfigProvider;
use Amasty\ExportCore\Model\Process\Process;
use Amasty\ExportCore\Processing\JobManager;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Status extends \Magento\Backend\App\Action
{
    public const ADMIN_RESOURCE = 'Amasty_ExportCore::export';

    /**
     * @var JobManager
     */
    private $jobManager;

    public function __construct(
        Action\Context $context,
        JobManager $jobManager
    ) {
        parent::__construct($context);
        $this->jobManager = $jobManager;
    }

    public function execute()
    {
        $result = [];
        if ($processIdentity = $this->getRequest()->getParam('processIdentity')) {
            /**
             * @var Process $process
             * @var ExportResultInterface $exportResult
             */
            list($process, $exportResult) = $this->jobManager->watchJob($processIdentity)->getJobState();
            
            if ($process->getPid()
                && !$this->jobManager->isPidAlive($process->getPid())
                && !in_array($process->getStatus(), [Process::STATUS_SUCCESS, Process::STATUS_FAILED])
            ) {
                $exportResult->logMessage(
                    ExportResultInterface::MESSAGE_CRITICAL,
                    __(
                        'The system process failed. For an error details please make sure that Debug mode is enabled '
                            . 'and see %1',
                        ConfigProvider::DEBUG_LOG_PATH
                    )
                );
            }
            
            if ($exportResult === null) {
                $result = [
                    'status' => 'starting',
                    'proceed' => 0,
                    'total' => 0,
                    'messages' => [
                        [
                            'type' => 'info',
                            'message' => __('Process Started')
                        ]
                    ]
                ];
            } else {
                $result = [
                    'status' => $process->getStatus(),
                    'proceed' => $exportResult->getRecordsProcessed(),
                    'total' => $exportResult->getTotalRecords(),
                    'messages' => $exportResult->getMessages()
                ];
            }
        } else {
            $result['error'] = __('Process Identity is not set.');
        }
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($result);

        return $resultJson;
    }
}
