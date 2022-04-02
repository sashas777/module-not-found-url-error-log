<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */

declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Controller\Adminhtml\Log;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\UrlRewrite\Model\UrlRewriteFactory;
use Magento\UrlRewrite\Controller\Adminhtml\Url\Rewrite;

/**
 * Class Save
 * Store the redirect entry
 */
class Save  extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'TheSGroup_NotFoundUrlLog::log';

    /**
     * @var UrlRewriteFactory
     */
    private $urlRewriteFactory;

    /**
     * @param Context $context
     * @param UrlRewriteFactory $urlRewriteFactory
     */
    public function __construct(
        Context $context,
        UrlRewriteFactory $urlRewriteFactory
    ) {
        $this->urlRewriteFactory = $urlRewriteFactory;
        parent::__construct($context);
    }

    /**
     * @return void
     */
    public function execute()
    {
        try {
            $model = $this->urlRewriteFactory->create();
            $model->setEntityType(Rewrite::ENTITY_TYPE_CUSTOM)
                  ->setRequestPath($this->getRequest()->getParam('request_path'))
                  ->setTargetPath($this->getRequest()->getParam('target_path'))
                  ->setRedirectType($this->getRequest()->getParam('redirect_type'))
                  ->setStoreId($this->getRequest()->getParam('store_id', 0))
                  ->setDescription($this->getRequest()->getParam('description'));
            $model->save();
            $this->messageManager->addSuccessMessage(__('The URL Rewrite has been saved.'));
            $this->_redirect('*/*/');
            return;
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage(
                $e,
                __('An error occurred while saving the URL rewrite. Please try to save again.')
            );
        }
        $this->getResponse()->setRedirect($this->_redirect->getRedirectUrl($this->getUrl('*')));
    }
}
