<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Controller\Adminhtml\Log;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use TheSGroup\NotFoundUrlLog\Model\Cleanup;
use Magento\Backend\App\Action;

/**
 * Class Clean
 */
class Clean extends Action implements HttpPostActionInterface
{
    /**
     * @var Cleanup
     */
    private $cleanModel;

    /**
     * @param Context $context
     * @param Cleanup $cleanModel
     */
    public function __construct(
        Context $context,
        Cleanup $cleanModel
    )  {
        $this->cleanModel = $cleanModel;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        try {
            $this->cleanModel->execute();
            $this->messageManager->addSuccessMessage(__('Log cleaned successfully.'));
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        $resultRedirect->setPath('*/*/');
        return $resultRedirect;
    }
}
