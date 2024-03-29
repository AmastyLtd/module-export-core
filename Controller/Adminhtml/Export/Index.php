<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) Amasty (https://www.amasty.com)
 * @package Export Core for Magento 2 (System)
 */

namespace Amasty\ExportCore\Controller\Adminhtml\Export;

use Magento\Framework\Controller\ResultFactory;

/**
 * @codeCoverageIgnore
 */
class Index extends \Magento\Backend\App\Action
{
    public const ADMIN_RESOURCE = 'Amasty_ExportCore::export';

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Amasty_ExportCore::export');
        $resultPage->addBreadcrumb(__('Amasty Export'), __('Amasty Export'));
        $resultPage->addBreadcrumb(__('Export'), __('Export'));
        $resultPage->getConfig()->getTitle()->prepend(__('Export'));

        return $resultPage;
    }
}
