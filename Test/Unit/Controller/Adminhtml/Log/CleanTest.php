<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */

declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Test\Unit\Controller\Adminhtml\Log;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect as ResultRedirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface;
use TheSGroup\NotFoundUrlLog\Controller\Adminhtml\Log\Clean;
use PHPUnit\Framework\TestCase;
use TheSGroup\NotFoundUrlLog\Model\Cleanup;

class CleanTest extends TestCase
{

    /** @var Clean object */
    private $object;

    private $context;

    private $cleanModel;

    private $resultRedirect;

    private $resultFactory;

    public function testExecute()
    {
        $this->cleanModel->expects($this->atLeastOnce())->method('execute');
        $this->resultRedirect->expects($this->atLeastOnce())
                             ->method('setPath')
                             ->with('*/*/')
                             ->willReturnSelf();
        $this->messageManager->expects($this->atLeastOnce())
                             ->method('addSuccessMessage')
                             ->with($expectedMessage);
       $this->assertEquals($this->resultRedirect, $this->object->execute());
    }

    protected function setUp(): void
    {
        $this->context = $this->getMockBuilder(Context::class)
                              ->getMock();
        $this->cleanModel = $this->getMockBuilder(Cleanup::class)
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

        $this->object = new Clean(
            $this->context,
            $this->cleanModel
        );
    }
}
