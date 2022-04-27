<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */

declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Test\Unit\Ui\Component\Listing\Columns;

use Magento\Framework\Phrase;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use TheSGroup\NotFoundUrlLog\Ui\Component\Listing\Columns\UrlActions;
use PHPUnit\Framework\TestCase;

/**
 * Class UrlActionsTest
 */
class UrlActionsTest extends TestCase
{

    /** @var UrlActions object */
    private $object;

    /**
     * @var ContextInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $context;

    /**
     * @var UiComponentFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    private $uiComponentFactory;

    /**
     * @var UrlInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $urlBuilder;

    /**
     * @return void
     */
    public function testPrepareDataSource()
    {
        $dataSource = [
            'data' => [
                'items' => [
                    [
                        'entity_id' => 1,
                        '' =>  [
                            'edit' => [
                                'href' => 'test',
                                'label' => new Phrase('Create a redirect'),
                                'hidden' => false,
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $this->urlBuilder->expects($this->atLeastOnce())->method('getUrl')->willReturn('test');
        $this->assertEquals($dataSource, $this->object->prepareDataSource($dataSource));
    }

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->context = $this->getMockBuilder(ContextInterface::class)
                              ->disableOriginalConstructor()
                              ->getMock();
        $this->uiComponentFactory = $this->getMockBuilder(UiComponentFactory::class)
                                         ->disableOriginalConstructor()
                                         ->getMock();
        $this->urlBuilder = $this->getMockBuilder(UrlInterface::class)
                                 ->disableOriginalConstructor()
                                 ->getMock();
        $this->object = new UrlActions(
            $this->context,
            $this->uiComponentFactory,
            $this->urlBuilder
        );
    }
}
