<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */

declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Test\Unit\Controller\Adminhtml\Log;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\Model\View\Result\Page;
use TheSGroup\NotFoundUrlLog\Controller\Adminhtml\Log\Index;
use PHPUnit\Framework\TestCase;

/**
 * Class IndexTest
 */
class IndexTest extends TestCase
{
    /** @var Index object */
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
     * @var Page|\PHPUnit\Framework\MockObject\MockObject
     */
    private $resultPage;

    /**
     * @return void
     */
    public function testExecute()
    {
        $this->resultPage->expects($this->atLeastOnce())->method('setActiveMenu')->willReturnSelf();
        $this->resultPage->expects($this->atLeastOnce())->method('addBreadcrumb')->willReturnSelf();
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
        $this->resultPage = $this->getMockBuilder(Page::class)
                                     ->disableOriginalConstructor()
                                     ->getMock();
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
        $this->object = new Index(
            $this->context
        );
    }
}
