<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */

declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Test\Unit\Cron;

use Magento\Framework\App\Config\ScopeConfigInterface;
use TheSGroup\NotFoundUrlLog\Cron\Clean;
use PHPUnit\Framework\TestCase;
use TheSGroup\NotFoundUrlLog\Model\Cleanup;

/**
 * Class CleanTest
 */
class CleanTest extends TestCase
{

    /** @var Clean object */
    private $object;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Cleanup
     */
    private $cleanup;

    /**
     * @var ScopeConfigInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $scopeConfig;

    /**
     * @return void
     */
    public function testExecute()
    {
        $this->scopeConfig->expects($this->atLeastOnce())->method('getValue')->willReturn(1);
        $this->cleanup->expects($this->atLeastOnce())->method('execute');
        $this->assertNull($this->object->execute());
    }

    /**
     * @return void
     */
    public function testExecuteDisabled()
    {
        $this->scopeConfig->expects($this->atLeastOnce())->method('getValue')->willReturn(0);
        $this->cleanup->expects($this->never())->method('execute');
        $this->assertNull($this->object->execute());
    }

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->cleanup = $this->getMockBuilder(Cleanup::class)
                                  ->disableOriginalConstructor()
                                  ->getMock();
        $this->scopeConfig = $this->getMockBuilder(ScopeConfigInterface::class)
                                  ->disableOriginalConstructor()
                                  ->getMock();

        $this->object = new Clean(
            $this->scopeConfig,
            $this->cleanup
        );
    }
}
