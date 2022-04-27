<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */

declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Unit\Test\Model;

use TheSGroup\NotFoundUrlLog\Model\Log;
use PHPUnit\Framework\TestCase;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb as AbstractDbResource;
use Magento\Framework\Data\Collection\AbstractDb;

/**
 * Class LogTest
 */
class LogTest extends TestCase
{

    /** @var Log object */
    private $object;

    /**
     * @var Context|\PHPUnit\Framework\MockObject\MockObject
     */
    private $context;

    /**
     * @var Registry|\PHPUnit\Framework\MockObject\MockObject
     */
    private $registry;

    /**
     * @var AbstractDbResource|\PHPUnit\Framework\MockObject\MockObject
     */
    private $resource;

    /**
     * @var AbstractDb|\PHPUnit\Framework\MockObject\MockObject
     */
    private $resourceCollection;

    /**
     * @return void
     */
    public function testSetReferUrl()
    {
        $this->assertEquals($this->object, $this->object->setReferUrl('test'));
    }

    /**
     * @return void
     */
    public function testGetIp()
    {
        $this->assertNull($this->object->getIp());
    }

    /**
     * @return void
     */
    public function testGetRequestUrl()
    {
        $this->assertNull($this->object->getRequestUrl());
    }

    /**
     * @return void
     */
    public function testSetUpdatedAt()
    {
        $this->assertEquals($this->object, $this->object->setUpdatedAt('test'));
    }

    /**
     * @return void
     */
    public function testGetOccurrences()
    {
        $this->assertNull($this->object->getOccurrences());
    }

    /**
     * @return void
     */
    public function testGetReferUrl()
    {
        $this->assertNull($this->object->getReferUrl());
    }

    /**
     * @return void
     */
    public function testSetOccurrences()
    {
        $this->assertEquals($this->object, $this->object->setOccurrences(1));
    }

    /**
     * @return void
     */
    public function testSetCreatedAt()
    {
        $this->assertEquals($this->object, $this->object->setCreatedAt('test'));
    }

    /**
     * @return void
     */
    public function testGetCreatedAt()
    {
        $this->assertNull($this->object->getCreatedAt());
    }

    /**
     * @return void
     */
    public function testGetEntityId()
    {
        $this->assertNull($this->object->getEntityId());
    }

    /**
     * @return void
     */
    public function testSetStoreId()
    {
        $this->assertEquals($this->object, $this->object->setStoreId(1));
    }

    /**
     * @return void
     */
    public function testSetIp()
    {
        $this->assertEquals($this->object, $this->object->setIp('test'));
    }

    /**
     * @return void
     */
    public function testSetRequestUrl()
    {
        $this->assertEquals($this->object, $this->object->setRequestUrl('test'));
    }

    /**
     * @return void
     */
    public function testGetUpdatedAt()
    {
        $this->assertNull($this->object->getUpdatedAt());
    }

    /**
     * @return void
     */
    public function testSetEntityId()
    {
        $this->assertEquals($this->object, $this->object->setEntityId('test'));
    }

    /**
     * @return void
     */
    public function testGetStoreId()
    {
        $this->assertNull($this->object->getStoreId());
    }

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->context = $this->getMockBuilder(Context::class)
                              ->disableOriginalConstructor()
                              ->getMock();
        $this->registry = $this->getMockBuilder(Registry::class)
                             ->disableOriginalConstructor()
                             ->getMock();
        $this->resource = $this->getMockBuilder(AbstractDbResource::class)
                               ->disableOriginalConstructor()
                               ->getMock();
        $this->resource->expects($this->any())->method('getIdFieldName')->willReturn('test');

        $this->resourceCollection = $this->getMockBuilder(AbstractDb::class)
                               ->disableOriginalConstructor()
                               ->getMock();
        $this->object = new Log(
            $this->context,
            $this->registry,
            $this->resource,
            $this->resourceCollection
        );
    }
}
