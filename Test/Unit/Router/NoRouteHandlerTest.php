<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */

declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Test\Unit\Router;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Area;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\State;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use TheSGroup\NotFoundUrlLog\Api\Data\LogInterfaceFactory;
use TheSGroup\NotFoundUrlLog\Api\Data\LogInterface;
use TheSGroup\NotFoundUrlLog\Api\LogRepositoryInterface;
use TheSGroup\NotFoundUrlLog\Router\NoRouteHandler;
use PHPUnit\Framework\TestCase;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Framework\Api\SearchCriteria;
use TheSGroup\NotFoundUrlLog\Api\Data\LogSearchResultsInterface;

/**
 * Class NoRouteHandlerTest
 */
class NoRouteHandlerTest extends TestCase
{
    /** @var NoRouteHandler object */
    private $object;

    /**
     * @var StoreManagerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $storeManager;

    /**
     * @var RemoteAddress|\PHPUnit\Framework\MockObject\MockObject
     */
    private $remoteAddress;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|LogRepositoryInterface
     */
    private $logRepository;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|LogInterfaceFactory
     */
    private $logInterfaceFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|LogInterface
     */
    private $logInterface;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|LoggerInterface
     */
    private $logger;

    /**
     * @var SearchCriteriaBuilder|\PHPUnit\Framework\MockObject\MockObject
     */
    private $searchCriteriaBuilder;

    /**
     * @var State|\PHPUnit\Framework\MockObject\MockObject
     */
    private $state;

    /**
     * @var RequestInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $request;

    /**
     * @var StoreInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $store;

    /**
     * @var SearchCriteria|\PHPUnit\Framework\MockObject\MockObject
     */
    private $searchCriteria;

    /**
     * @return void
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function testProcessIncorrectAreaCode()
    {
        $this->state->expects($this->atLeastOnce())->method('getAreaCode')->willReturn('test');
        $this->assertFalse($this->object->process($this->request));
    }

    /**
     * @return void
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function testProcessRedirectExists()
    {
        $this->state->expects($this->atLeastOnce())->method('getAreaCode')->willReturn(Area::AREA_FRONTEND);
        $this->request->expects($this->atLeastOnce())->method('getServer')->willReturn('https://test.com/var');
        $this->store->expects($this->atLeastOnce())->method('getId')->willReturn(1);

        $searchResult = $this->getMockBuilder(LogSearchResultsInterface::class)
                             ->disableOriginalConstructor()
                             ->getMock();
        $searchResult->expects($this->atLeastOnce())->method('getTotalCount')->willReturn(1);
        $this->logInterface->expects($this->atLeastOnce())->method('getOccurrences')->willReturn(1);
        $this->logInterface->expects($this->atLeastOnce())->method('setOccurrences')->willReturnSelf();
        $searchResult->expects($this->atLeastOnce())->method('getItems')->willReturn([$this->logInterface]);
        $this->logRepository->expects($this->atLeastOnce())->method('getList')->willReturn($searchResult);
        $this->logRepository->expects($this->atLeastOnce())->method('save');
        $this->assertFalse($this->object->process($this->request));
    }

    /**
     * @return void
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function testProcessRedirectExistsError()
    {
        $this->state->expects($this->atLeastOnce())->method('getAreaCode')->willReturn(Area::AREA_FRONTEND);
        $this->request->expects($this->atLeastOnce())->method('getServer')->willReturn('https://test.com/var');
        $this->store->expects($this->atLeastOnce())->method('getId')->willReturn(1);

        $searchResult = $this->getMockBuilder(LogSearchResultsInterface::class)
                             ->disableOriginalConstructor()
                             ->getMock();
        $searchResult->expects($this->atLeastOnce())->method('getTotalCount')->willReturn(1);
        $this->logInterface->expects($this->atLeastOnce())->method('getOccurrences')->willReturn(1);
        $this->logInterface->expects($this->atLeastOnce())->method('setOccurrences')->willReturnSelf();
        $searchResult->expects($this->atLeastOnce())->method('getItems')->willReturn([$this->logInterface]);
        $this->logRepository->expects($this->atLeastOnce())->method('getList')->willReturn($searchResult);
        $this->logRepository->expects($this->atLeastOnce())->method('save')->willThrowException(new \Exception());
        $this->logger->expects($this->atLeastOnce())->method('error');
        $this->assertFalse($this->object->process($this->request));
    }

    /**
     * @return void
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function testProcess()
    {
        $this->state->expects($this->atLeastOnce())->method('getAreaCode')->willReturn(Area::AREA_FRONTEND);
        $this->request->expects($this->atLeastOnce())->method('getServer')->willReturn('https://test.com/var');
        $this->store->expects($this->atLeastOnce())->method('getId')->willReturn(1);

        $searchResult = $this->getMockBuilder(LogSearchResultsInterface::class)
                             ->disableOriginalConstructor()
                             ->getMock();
        $searchResult->expects($this->atLeastOnce())->method('getTotalCount')->willReturn(0);
        $this->logRepository->expects($this->atLeastOnce())->method('getList')->willReturn($searchResult);

        $this->remoteAddress->expects($this->atLeastOnce())->method('getRemoteAddress')->willReturn('1');
        $this->logInterface->expects($this->atLeastOnce())->method('setIp')->willReturnSelf();
        $this->logInterface->expects($this->atLeastOnce())->method('setReferUrl')->willReturnSelf();
        $this->logInterface->expects($this->atLeastOnce())->method('setRequestUrl')->willReturnSelf();
        $this->logInterface->expects($this->atLeastOnce())->method('setOccurrences')->willReturnSelf();
        $this->logInterface->expects($this->atLeastOnce())->method('setStoreId')->willReturnSelf();
        $this->logRepository->expects($this->atLeastOnce())->method('save');

        $this->assertFalse($this->object->process($this->request));
    }

    /**
     * @return void
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function testProcessException()
    {
        $this->state->expects($this->atLeastOnce())->method('getAreaCode')->willReturn(Area::AREA_FRONTEND);
        $this->request->expects($this->atLeastOnce())->method('getServer')->willReturn('https://test.com/var');
        $this->store->expects($this->atLeastOnce())->method('getId')->willReturn(1);

        $searchResult = $this->getMockBuilder(LogSearchResultsInterface::class)
                             ->disableOriginalConstructor()
                             ->getMock();
        $searchResult->expects($this->atLeastOnce())->method('getTotalCount')->willReturn(0);
        $this->logRepository->expects($this->atLeastOnce())->method('getList')->willReturn($searchResult);

        $this->remoteAddress->expects($this->atLeastOnce())->method('getRemoteAddress')->willReturn('1');
        $this->logInterface->expects($this->atLeastOnce())->method('setIp')->willReturnSelf();
        $this->logInterface->expects($this->atLeastOnce())->method('setReferUrl')->willReturnSelf();
        $this->logInterface->expects($this->atLeastOnce())->method('setRequestUrl')->willReturnSelf();
        $this->logInterface->expects($this->atLeastOnce())->method('setOccurrences')->willReturnSelf();
        $this->logInterface->expects($this->atLeastOnce())->method('setStoreId')->willReturnSelf();
        $this->logRepository->expects($this->atLeastOnce())->method('save')->willThrowException(new \Exception());
        $this->logger->expects($this->atLeastOnce())->method('error');

        $this->assertFalse($this->object->process($this->request));
    }

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->storeManager = $this->getMockBuilder(StoreManagerInterface::class)
                                   ->disableOriginalConstructor()
                                   ->getMock();
        $this->store = $this->getMockBuilder(StoreInterface::class)
                            ->disableOriginalConstructor()
                            ->getMock();
        $this->storeManager->expects($this->any())->method('getStore')->willReturn($this->store);
        $this->remoteAddress = $this->getMockBuilder(RemoteAddress::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();
        $this->logRepository = $this->getMockBuilder(LogRepositoryInterface::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();
        $this->logInterfaceFactory = $this->getMockBuilder(LogInterfaceFactory::class)
                                          ->disableOriginalConstructor()
                                          ->getMock();
        $this->logInterface = $this->getMockBuilder(LogInterface::class)
                                   ->disableOriginalConstructor()
                                   ->getMock();
        $this->logInterfaceFactory->expects($this->any())->method('create')->willReturn($this->logInterface);

        $this->logger = $this->getMockBuilder(LoggerInterface::class)
                             ->disableOriginalConstructor()
                             ->getMock();
        $this->searchCriteriaBuilder = $this->getMockBuilder(SearchCriteriaBuilder::class)
                                            ->disableOriginalConstructor()
                                            ->getMock();
        $this->searchCriteria = $this->getMockBuilder(SearchCriteria::class)
                                     ->disableOriginalConstructor()
                                     ->getMock();
        $this->searchCriteriaBuilder->expects($this->any())->method('addFilter')->willReturnSelf();
        $this->searchCriteriaBuilder->expects($this->any())->method('setPageSize')->willReturnSelf();
        $this->searchCriteriaBuilder->expects($this->any())->method('create')->willReturn($this->searchCriteria);

        $this->state = $this->getMockBuilder(State::class)
                            ->disableOriginalConstructor()
                            ->getMock();
        $this->request = $this->getMockBuilder(RequestInterface::class)
                              ->disableOriginalConstructor()
                              ->addMethods(['getServer'])
                              ->getMockForAbstractClass();

        $this->object = new NoRouteHandler(
            $this->storeManager,
            $this->remoteAddress,
            $this->logRepository,
            $this->logInterfaceFactory,
            $this->logger,
            $this->searchCriteriaBuilder,
            $this->state
        );
    }
}
