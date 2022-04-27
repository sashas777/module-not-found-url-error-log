<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */

declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Test\Unit\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Phrase;
use TheSGroup\NotFoundUrlLog\Model\LogRepository;
use PHPUnit\Framework\TestCase;
use TheSGroup\NotFoundUrlLog\Model\ResourceModel\Log as ResourceLog;
use TheSGroup\NotFoundUrlLog\Model\ResourceModel\Log\CollectionFactory as LogCollectionFactory;
use TheSGroup\NotFoundUrlLog\Model\ResourceModel\Log\Collection as LogCollection;
use TheSGroup\NotFoundUrlLog\Api\Data\LogInterfaceFactory;
use TheSGroup\NotFoundUrlLog\Api\Data\LogSearchResultsInterfaceFactory;
use TheSGroup\NotFoundUrlLog\Api\Data\LogSearchResultsInterface;
use TheSGroup\NotFoundUrlLog\Model\Log as LogModel;

/**
 * Class LogRepositoryTest
 */
class LogRepositoryTest extends TestCase
{
    /** @var LogRepository object */
    private $object;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|ResourceLog
     */
    private $resource;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|LogInterfaceFactory
     */
    private $logFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|LogModel
     */
    private $log;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|LogCollectionFactory
     */
    private $logCollectionFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|LogCollection
     */
    private $logCollection;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|LogSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|LogSearchResultsInterface
     */
    private $searchResults;

    /**
     * @var CollectionProcessorInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $collectionProcessor;

    /**
     * @var SearchCriteriaInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $criteria;

    /**
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function testGetList()
    {
        $this->collectionProcessor->expects($this->atLeastOnce())->method('process')->willReturnSelf();
        $this->searchResults->expects($this->atLeastOnce())->method('setSearchCriteria')->willReturnSelf();
        $this->logCollection->expects($this->once())
                         ->method('getIterator')
                         ->willReturn(new \ArrayObject([$this->log]));
        $this->assertEquals($this->searchResults, $this->object->getList($this->criteria));
    }


    /**
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function testDeleteById()
    {
        $this->log->expects($this->atLeastOnce())->method('getId')->willReturn(1);
        $this->resource->expects($this->atLeastOnce())->method('load')->willReturnSelf();
        $this->resource->expects($this->atLeastOnce())->method('delete')->willReturnSelf();
        $this->assertTrue($this->object->deleteById(1));
    }

    /**
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function testDeleteException()
    {
        $this->resource->expects($this->atLeastOnce())->method('load')->willReturnSelf();
        $this->resource->expects($this->atLeastOnce())->method('delete')->willThrowException(new \Exception());
        $this->expectExceptionMessage('Could not delete the Log: ');
        $this->object->delete($this->log);
    }

    /**
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function testSave()
    {
        $this->resource->expects($this->atLeastOnce())->method('save')->willThrowException(new \Exception());
        $this->expectExceptionMessage('Could not save the log: ');
        $this->object->save($this->log);
    }

    /**
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function testSaveException()
    {
        $this->resource->expects($this->atLeastOnce())->method('save')->willReturnSelf();
        $this->assertEquals($this->log, $this->object->save($this->log));
    }


    /**
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function testGetException()
    {
        $this->resource->expects($this->atLeastOnce())->method('load')->willReturnSelf();
        $this->expectExceptionMessage('Log with id "1" does not exist.');
        $this->object->get(1);
    }

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->resource = $this->getMockBuilder(ResourceLog::class)
                              ->disableOriginalConstructor()
                              ->getMock();
        $this->logFactory = $this->getMockBuilder(LogInterfaceFactory::class)
                               ->disableOriginalConstructor()
                               ->getMock();
        $this->log = $this->getMockBuilder(LogModel::class)
                                 ->disableOriginalConstructor()
                                 ->getMock();
        $this->logFactory->expects($this->any())->method('create')->willReturn($this->log);

        $this->logCollectionFactory = $this->getMockBuilder(LogCollectionFactory::class)
                               ->disableOriginalConstructor()
                               ->getMock();
        $this->logCollection = $this->getMockBuilder(LogCollection::class)
                         ->disableOriginalConstructor()
                         ->getMock();
        $this->logCollectionFactory->expects($this->any())->method('create')->willReturn($this->logCollection);

        $this->searchResultsFactory = $this->getMockBuilder(LogSearchResultsInterfaceFactory::class)
                               ->disableOriginalConstructor()
                               ->getMock();
        $this->searchResults = $this->getMockBuilder(LogSearchResultsInterface::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();
        $this->searchResultsFactory->expects($this->any())->method('create')->willReturn($this->searchResults);


        $this->collectionProcessor = $this->getMockBuilder(CollectionProcessorInterface::class)
                               ->disableOriginalConstructor()
                               ->getMock();
        $this->criteria = $this->getMockBuilder(SearchCriteriaInterface::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();
        $this->object = new LogRepository(
            $this->resource,
            $this->logFactory,
            $this->logCollectionFactory,
            $this->searchResultsFactory,
            $this->collectionProcessor,
        );
    }
}
