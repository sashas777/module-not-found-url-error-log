<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */

declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Test\Unit\Controller\Adminhtml\Log\Save;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Redirect as ResultRedirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Phrase;
use Magento\UrlRewrite\Model\UrlRewrite;
use Magento\UrlRewrite\Model\UrlRewriteFactory;
use TheSGroup\NotFoundUrlLog\Controller\Adminhtml\Log\Save;
use PHPUnit\Framework\TestCase;

/**
 * Class SaveTest
 */
class SaveTest extends TestCase
{

    /** @var Save object */
    private $object;

    /**
     * @var Context|\PHPUnit\Framework\MockObject\MockObject
     */
    private $context;

    /**
     * @var ResultRedirect|\PHPUnit\Framework\MockObject\MockObject
     */
    private $resultRedirect;

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
     * @var RequestInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $requestMock;

    /**
     * @return void
     */
    public function testExecute()
    {
        $this->resultRedirect->expects($this->atLeastOnce())
                             ->method('setPath')
                             ->willReturnSelf();

        $this->requestMock->expects($this->atLeastOnce())->method('getParam')->willReturn('1');
        $expectedMessage = new Phrase('The URL Rewrite has been saved.');
        $this->messageManager->expects($this->atLeastOnce())
                             ->method('addSuccessMessage')
                             ->with($expectedMessage);
        $this->assertEquals($this->resultRedirect, $this->object->execute());
    }

    /**
     * @return void
     */
    public function testExecuteLocalizedException()
    {
        $this->resultRedirect->expects($this->atLeastOnce())
                             ->method('setPath')
                             ->willReturnSelf();
        $this->requestMock->expects($this->atLeastOnce())->method('getParam')->willThrowException(new LocalizedException(new Phrase('test')));
        $expectedMessage = new Phrase('test');
        $this->messageManager->expects($this->atLeastOnce())
                             ->method('addErrorMessage')
                             ->with($expectedMessage);
        $this->assertEquals($this->resultRedirect, $this->object->execute());
    }

    /**
     * @return void
     */
    public function testExecuteException()
    {
        $this->resultRedirect->expects($this->atLeastOnce())
                             ->method('setPath')
                             ->willReturnSelf();
        $this->requestMock->expects($this->atLeastOnce())->method('getParam')->willThrowException(new \Exception());
        $this->messageManager->expects($this->atLeastOnce())
                             ->method('addExceptionMessage');
        $this->assertEquals($this->resultRedirect, $this->object->execute());
    }

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->urlRewriteFactory = $this->getMockBuilder(UrlRewriteFactory::class)
                                        ->disableOriginalConstructor()
                                        ->getMock();
        $this->urlRewrite = $this->getMockBuilder(UrlRewrite::class)
                                 ->disableOriginalConstructor()
                                 ->onlyMethods(['save'])
                                 ->addMethods(
                                     [
                                         'setRequestPath',
                                         'setStoreId',
                                         'setEntityType',
                                         'setDescription',
                                         'setTargetPath',
                                         'setRedirectType'
                                     ]
                                 )
                                 ->getMockForAbstractClass();
        $this->urlRewrite->expects($this->any())->method('setEntityType')->willReturnSelf();
        $this->urlRewrite->expects($this->any())->method('setRequestPath')->willReturnSelf();
        $this->urlRewrite->expects($this->any())->method('setTargetPath')->willReturnSelf();
        $this->urlRewrite->expects($this->any())->method('setRedirectType')->willReturnSelf();
        $this->urlRewrite->expects($this->any())->method('setStoreId')->willReturnSelf();
        $this->urlRewrite->expects($this->any())->method('setDescription')->willReturnSelf();
        $this->urlRewrite->expects($this->any())->method('save')->willReturnSelf();
        $this->urlRewriteFactory->expects($this->any())
                                ->method('create')
                                ->willReturn($this->urlRewrite);
        $this->requestMock = $this->getMockBuilder(RequestInterface::class)
                                  ->disableOriginalConstructor()
                                  ->getMock();
        $this->context = $this->getMockBuilder(Context::class)
                              ->disableOriginalConstructor()
                              ->getMock();
        $this->resultRedirect = $this->getMockBuilder(ResultRedirect::class)
                                     ->disableOriginalConstructor()
                                     ->getMock();
        $this->resultFactory = $this->getMockBuilder(ResultFactory::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();
        $this->resultFactory->expects($this->any())
                            ->method('create')
                            ->willReturnMap([
                                [ResultFactory::TYPE_REDIRECT, [], $this->resultRedirect],
                            ]);
        $this->messageManager = $this->getMockBuilder(ManagerInterface::class)
                                     ->getMockForAbstractClass();

        $this->context->expects($this->any())
                      ->method('getResultFactory')
                      ->willReturn($this->resultFactory);
        $this->context->expects($this->any())
                      ->method('getMessageManager')
                      ->willReturn($this->messageManager);
        $this->context->expects($this->once())
                      ->method('getRequest')
                      ->willReturn($this->requestMock);

        $this->object = new Save(
            $this->context,
            $this->urlRewriteFactory
        );
    }
}
