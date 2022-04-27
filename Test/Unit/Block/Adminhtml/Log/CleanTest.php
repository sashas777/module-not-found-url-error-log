<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */

declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Test\Unit\Block\Adminhtml\Log;

use Magento\Backend\Block\Template\Context;
use TheSGroup\NotFoundUrlLog\Block\Adminhtml\Log\Clean;
use PHPUnit\Framework\TestCase;
use Magento\Framework\UrlInterface;

/**
 * Class CleanTest
 */
class CleanTest extends TestCase
{

    /** @var Clean object */
    private $object;

    /**
     * @var Context|\PHPUnit\Framework\MockObject\MockObject
     */
    private $context;

    /**
     * @var UrlInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $urlBuilder;

    /**
     * @return void
     */
    public function testGetButtonData()
    {
        $data = [
            'id' => 'delete',
            'label' => __('Cleanup'),
            'on_click' => "deleteConfirm('" .__('Are you sure you want to clean old entries?') ."', 'test', {data: {}})",
            'class' => 'primary',
            'sort_order' => 10
        ];
        $this->urlBuilder->expects($this->atLeastOnce())->method('getUrl')->willReturn('test');
        $this->assertEquals($data, $this->object->getButtonData());
    }

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->context = $this->getMockBuilder(Context::class)
                              ->disableOriginalConstructor()
                              ->getMock();
        $this->urlBuilder = $this->getMockBuilder(UrlInterface::class)
                              ->disableOriginalConstructor()
                              ->getMock();
        $this->context->expects($this->any())
                      ->method('getUrlBuilder')
                      ->willReturn($this->urlBuilder);
        $this->object = new Clean(
            $this->context
        );
    }
}
