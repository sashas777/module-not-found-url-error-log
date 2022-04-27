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
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\UrlRewrite\Model\UrlRewriteFactory;
use TheSGroup\NotFoundUrlLog\Api\LogRepositoryInterface;
use Magento\UrlRewrite\Block\Edit;
use TheSGroup\NotFoundUrlLog\Block\Adminhtml\Log\Edit\Form;

/**
 * Class CreateRedirect
 * Create redirect controller
 */
class CreateRedirect extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'TheSGroup_NotFoundUrlLog::log';

    /**
     * @var UrlRewriteFactory
     */
    private $urlRewriteFactory;

    /**
     * @var LogRepositoryInterface
     */
    private $logRepository;

    /**
     * Constructor
     *
     * @param Context $context
     * @param UrlRewriteFactory $urlRewriteFactory
     * @param LogRepositoryInterface $logRepository
     */
    public function __construct(
        Context $context,
        UrlRewriteFactory $urlRewriteFactory,
        LogRepositoryInterface $logRepository
    ) {
        $this->urlRewriteFactory = $urlRewriteFactory;
        $this->logRepository = $logRepository;
        parent::__construct($context);
    }

    /**
     *  Show redirect create page
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Magento_UrlRewrite::urlrewrite');

        /** @var Edit $editBlock */
        $editBlock = $resultPage->getLayout()->createBlock(
            Edit::class,
            '',
            ['data' => ['url_rewrite' => $this->getUrlRewrite()]]
        );
        $editBlock->updateButton('back', 'onclick', 'setLocation(\'' . $this->getUrl('*/*/') . '\')');

        /** @var Form $formBlock */
        $formBlock = $resultPage->getLayout()->createBlock(
            Form::class,
            '',
            ['data' => ['url_rewrite' => $this->getUrlRewrite()]]
        );

        $editBlock->setChild('form', $formBlock);

        $resultPage->getConfig()->getTitle()->prepend($editBlock->getHeaderText());
        $this->_addContent($editBlock);

        return $resultPage;
    }

    /**
     * Get URL rewrite from request
     *
     * @return \Magento\UrlRewrite\Model\UrlRewrite
     */
    private function getUrlRewrite()
    {
        $logEntry = $this->logRepository->get($this->getRequest()->getParam('id'));
        /** @var  \Magento\UrlRewrite\Model\UrlRewrite $urlRewrite */
        $urlRewrite = $this->urlRewriteFactory->create();
        $urlRewrite->setRequestPath($logEntry->getRequestUrl());
        $urlRewrite->setStoreId($logEntry->getStoreId());
        return $urlRewrite;
    }
}
