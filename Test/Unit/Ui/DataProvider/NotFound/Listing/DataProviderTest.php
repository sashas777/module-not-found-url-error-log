<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */

declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Test\Unit\Ui\DataProvider\NotFound\Listing;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\App\RequestInterface;
use TheSGroup\NotFoundUrlLog\Ui\DataProvider\NotFound\Listing\DataProvider;
use PHPUnit\Framework\TestCase;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\Search\SearchCriteria;
use Magento\Framework\DB\Select;
use Magento\Framework\DB\Adapter\AdapterInterface;

/**
 * Class DataProviderTest
 */
class DataProviderTest extends TestCase
{
    /** @var DataProvider object */
    private $object;

    /**
     * @var Filter|\PHPUnit\Framework\MockObject\MockObject
     */
    private $filter;

    /**
     * @var SearchCriteriaBuilder|\PHPUnit\Framework\MockObject\MockObject
     */
    private $searchCriteriaBuilder;

    /**
     * @var SearchCriteria|\PHPUnit\Framework\MockObject\MockObject
     */
    private $searchCriteria;

    /**
     * @var ReportingInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $reporting;

    /**
     * @var RequestInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $request;

    /**
     * @var FilterBuilder|\PHPUnit\Framework\MockObject\MockObject
     */
    private $filterBuilder;

    /**
     * @var SearchResultInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $searchResults;

    /**
     * @var Select|\PHPUnit\Framework\MockObject\MockObject
     */
    private $select;

    /**
     * @var AdapterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $connection;

    /**
     * @return void
     */
    public function testAddFilter()
    {
        $this->filter->expects($this->atLeastOnce())->method('getField')->willReturn('redirect_exists');
        $this->filter->expects($this->atLeastOnce())->method('getValue')->willReturn(1);
        $this->filter->expects($this->atLeastOnce())->method('setField')->willReturnSelf();
        $this->filter->expects($this->atLeastOnce())->method('setValue')->willReturnSelf();
        $this->filter->expects($this->atLeastOnce())->method('setConditionType')->willReturnSelf();

        $this->assertNull($this->object->addFilter($this->filter));
    }

    /**
     * @return void
     */
    public function testAddFilterRedirectNotExist()
    {
        $this->filter->expects($this->atLeastOnce())->method('getField')->willReturn('redirect_exists');
        $this->filter->expects($this->atLeastOnce())->method('getValue')->willReturn(0);
        $this->filter->expects($this->atLeastOnce())->method('setField')->willReturnSelf();
        $this->filter->expects($this->never())->method('setValue');
        $this->filter->expects($this->atLeastOnce())->method('setConditionType')->willReturnSelf();

        $this->assertNull($this->object->addFilter($this->filter));
    }

    /**
     * @return void
     */
    public function testAddFilterStoreId()
    {
        $this->filter->expects($this->atLeastOnce())->method('getField')->willReturn('store_id');
        $this->filter->expects($this->atLeastOnce())->method('setField')->willReturnSelf();
        $this->filter->expects($this->never())->method('setConditionType');

        $this->assertNull($this->object->addFilter($this->filter));
    }

    /**
     * @return void
     */
    public function testGetSearchResult()
    {
        $this->reporting->expects($this->atLeastOnce())->method('search')->willReturn($this->searchResults);
        $this->connection->expects($this->atLeastOnce())->method('getTableName')->willReturn('url_rewrite');
        $this->assertEquals($this->searchResults, $this->object->getSearchResult());
    }

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->filter = $this->getMockBuilder(Filter::class)
                             ->disableOriginalConstructor()
                             ->getMock();
        $this->searchCriteriaBuilder = $this->getMockBuilder(SearchCriteriaBuilder::class)
                                            ->disableOriginalConstructor()
                                            ->getMock();
        $this->searchCriteria = $this->getMockBuilder(SearchCriteria::class)
                                     ->disableOriginalConstructor()
                                     ->getMock();
        $this->select = $this->getMockBuilder(Select::class)
                             ->disableOriginalConstructor()
                             ->getMock();
        $this->searchCriteriaBuilder->expects($this->any())->method('addFilter')->willReturnSelf();
        $this->searchCriteriaBuilder->expects($this->any())->method('create')->willReturn($this->searchCriteria);
        $this->searchCriteria->expects($this->any())->method('setRequestName')->willReturnSelf();


        $this->reporting = $this->getMockBuilder(ReportingInterface::class)
                                ->disableOriginalConstructor()
                                ->getMock();
        $this->request = $this->getMockBuilder(RequestInterface::class)
                              ->disableOriginalConstructor()
                              ->getMock();
        $this->filterBuilder = $this->getMockBuilder(FilterBuilder::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();
        $this->searchResults = $this->getMockBuilder(SearchResultInterface::class)
                                    ->disableOriginalConstructor()
                                    ->addMethods(['getSelect', 'getConnection'])
                                    ->getMockForAbstractClass();
        $this->connection = $this->getMockBuilder(AdapterInterface::class)
                                 ->disableOriginalConstructor()
                                 ->getMock();
        $this->searchResults->expects($this->any())->method('getSelect')->willReturn($this->select);
        $this->searchResults->expects($this->any())->method('getConnection')->willReturn($this->connection);
        $this->object = new DataProvider(
            'test',
            'test',
            'test',
            $this->reporting,
            $this->searchCriteriaBuilder,
            $this->request,
            $this->filterBuilder
        );
    }
}
