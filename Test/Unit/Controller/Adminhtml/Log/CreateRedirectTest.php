<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */

declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Test\Unit\Controller\Adminhtml\Log;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\UrlRewrite\Model\UrlRewriteFactory;
use TheSGroup\NotFoundUrlLog\Api\LogRepositoryInterface;
use TheSGroup\NotFoundUrlLog\Controller\Adminhtml\Log\CreateRedirect;
use PHPUnit\Framework\TestCase;
use Magento\UrlRewrite\Model\UrlRewrite;
use Magento\Framework\View\LayoutInterface;
use Magento\Backend\Block\Widget\Container;
use TheSGroup\NotFoundUrlLog\Api\Data\LogInterface;
use Magento\Framework\View\Page\Config;
use Magento\Framework\View\Page\Title;
use Magento\Backend\Helper\Data;

/**
 * Class CreateRedirectTest
 */
class CreateRedirectTest extends TestCase
{

    /** @var CreateRedirect object */
    private $object;

    /**
     * @var Context|\PHPUnit\Framework\MockObject\MockObject
     */
    private $context;

    /**
     * @var ResultFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    private $resultFactory;

    /**
     * @var UrlRewriteFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    private $urlRewriteFactory;

    /**
     * @var UrlRewrite|\PHPUnit\Framework\MockObject\MockObject
     */
    private $urlRewrite;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|LogRepositoryInterface
     */
    private $logRepository;

    /**
     * @var LayoutInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $layout;

    /**
     * @var Container|\PHPUnit\Framework\MockObject\MockObject
     */
    private $block;

    /**
     * @var RequestInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $requestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|LogInterface
     */
    private $log;

    /**
     * @var
     */
    private $pageConfig;

    /**
     * @var Title|\PHPUnit\Framework\MockObject\MockObject
     */
    private $title;

    /**
     * @var Data|\PHPUnit\Framework\MockObject\MockObject
     */
    private $helper;

    /**
     * @var Page|\PHPUnit\Framework\MockObject\MockObject
     */
    private $resultPage;

    /**
     * @return void
     */
    public function testExecute()
    {
        $this->log->expects($this->atLeastOnce())->method('getRequestUrl')->willReturn('test');
        $this->log->expects($this->atLeastOnce())->method('getStoreId')->willReturn(1);
        $this->title->expects($this->atLeastOnce())->method('prepend')->willReturnSelf();

        $this->requestMock->expects($this->atLeastOnce())->method('getParam')->willReturn(1);
        $this->helper->expects($this->atLeastOnce())->method('getUrl')->willReturn('test');

        $this->urlRewrite->expects($this->atLeastOnce())->method('setRequestPath')->willReturnSelf();
        $this->urlRewrite->expects($this->atLeastOnce())->method('setStoreId')->willReturnSelf();

        $this->resultPage->expects($this->atLeastOnce())->method('setActiveMenu')->willReturnSelf();
        $this->resultPage->expects($this->atLeastOnce())->method('addContent')->willReturnSelf();

        $this->resultPage->expects($this->atLeastOnce())->method('getConfig')->willReturnSelf();
        $this->resultPage->expects($this->atLeastOnce())->method('addContent')->willReturnSelf();

        $this->block->expects($this->atLeastOnce())->method('updateButton')->willReturnSelf();
        $this->block->expects($this->atLeastOnce())->method('setChild')->willReturnSelf();
        $this->block->expects($this->atLeastOnce())->method('getHeaderText')->willReturn('test');

        $this->assertEquals($this->resultPage, $this->object->execute());
    }

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->context = $this->getMockBuilder(Context::class)
                              ->disableOriginalConstructor()
                              ->getMock();
        $this->requestMock = $this->getMockBuilder(RequestInterface::class)
                                  ->disableOriginalConstructor()
                                  ->getMock();
        $this->helper = $this->getMockBuilder(Data::class)
                                  ->disableOriginalConstructor()
                                  ->getMock();
        $this->urlRewriteFactory = $this->getMockBuilder(UrlRewriteFactory::class)
                                        ->disableOriginalConstructor()
                                        ->getMock();
        $this->urlRewrite = $this->getMockBuilder(UrlRewrite::class)
                                 ->disableOriginalConstructor()
                                 ->addMethods(['setRequestPath', 'setStoreId'])
                                 ->getMockForAbstractClass();
        $this->urlRewriteFactory->expects($this->any())
                                ->method('create')
                                ->willReturn($this->urlRewrite);
        $this->logRepository = $this->getMockBuilder(LogRepositoryInterface::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();
        $this->log = $this->getMockBuilder(LogInterface::class)
                          ->disableOriginalConstructor()
                          ->getMock();
        $this->logRepository->expects($this->atLeastOnce())->method('get')->willReturn($this->log);
        $this->resultPage = $this->getMockBuilder(Page::class)
                                 ->disableOriginalConstructor()
                                 ->getMock();
        $this->layout = $this->getMockBuilder(LayoutInterface::class)
                             ->disableOriginalConstructor()
                             ->getMock();
        $this->block = $this->getMockBuilder(Container::class)
                            ->disableOriginalConstructor()
                            ->getMock();
        $this->config = $this->getMockBuilder(Config::class)
                             ->disableOriginalConstructor()
                             ->getMock();
        $this->title = $this->getMockBuilder(Title::class)
                            ->disableOriginalConstructor()
                            ->getMock();
        $this->resultPage->expects($this->any())
                         ->method('getLayout')
                         ->willReturn($this->layout);
        $this->resultPage->expects($this->any())
                         ->method('getConfig')
                         ->willReturn($this->config);
        $this->config->expects($this->any())
                     ->method('getTitle')
                     ->willReturn($this->title);

        $this->layout->expects($this->any())
                     ->method('createBlock')
                     ->willReturn($this->block);
        $this->resultFactory = $this->getMockBuilder(ResultFactory::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();
        $this->resultFactory->expects($this->any())
                            ->method('create')
                            ->willReturnMap([
                                [ResultFactory::TYPE_PAGE, [], $this->resultPage],
                            ]);
        $this->context->expects($this->any())
                      ->method('getResultFactory')
                      ->willReturn($this->resultFactory);
        $this->context->expects($this->once())
                      ->method('getRequest')
                      ->willReturn($this->requestMock);
        $this->context->expects($this->any())
                      ->method('getHelper')
                      ->willReturn($this->helper);

        $this->object = new CreateRedirect(
            $this->context,
            $this->urlRewriteFactory,
            $this->logRepository,
        );
    }
}
