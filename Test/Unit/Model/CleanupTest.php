<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */

declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Test\Unit\Model;

use TheSGroup\NotFoundUrlLog\Model\Cleanup;
use PHPUnit\Framework\TestCase;
use TheSGroup\NotFoundUrlLog\Model\ResourceModel\Log\CollectionFactory;
use TheSGroup\NotFoundUrlLog\Model\ResourceModel\Log\Collection;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\DB\Adapter\AdapterInterface;

/**
 * Class CleanupTest
 */
class CleanupTest extends TestCase
{

    /** @var Cleanup object */
    private $object;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Collection
     */
    private $collection;

    /**
     * @var AbstractDb|\PHPUnit\Framework\MockObject\MockObject
     */
    private $resource;

    /**
     * @var AdapterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $adapter;

    /**
     * @return void
     */
    public function testExecute()
    {
        $this->collection->expects($this->any())->method('getAllIds')->willReturn([1,2]);
        $this->assertNull($this->object->execute(1));
    }

    /**
     * @return void
     */
    public function testExecuteAll()
    {
        $this->collection->expects($this->never())->method('getAllIds');
        $this->assertNull($this->object->execute(0));
    }

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->collectionFactory = $this->getMockBuilder(CollectionFactory::class)
                                  ->disableOriginalConstructor()
                                  ->getMock();
        $this->collection = $this->getMockBuilder(Collection::class)
                                        ->disableOriginalConstructor()
                                        ->getMock();
        $this->resource = $this->getMockBuilder(AbstractDb::class)
                                 ->disableOriginalConstructor()
                                 ->getMock();
        $this->adapter = $this->getMockBuilder(AdapterInterface::class)
                                 ->disableOriginalConstructor()
                                 ->getMock();
        $this->collection->expects($this->any())->method('addFieldToSelect')->willReturnSelf();
        $this->collection->expects($this->any())->method('addFieldToFilter')->willReturnSelf();
        $this->collection->expects($this->any())->method('getResource')->willReturn($this->resource);
        $this->adapter->expects($this->any())->method('getTableName')->willReturn('test');
        $this->resource->expects($this->any())->method('getConnection')->willReturn($this->adapter);

        $this->collectionFactory->expects($this->any())->method('create')->willReturn($this->collection);

        $this->object = new Cleanup(
            $this->collectionFactory
        );
    }
}
