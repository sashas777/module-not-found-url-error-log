<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */
declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Router;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Store\Model\StoreManagerInterface;
use TheSGroup\NotFoundUrlLog\Api\Data\LogInterfaceFactory;
use TheSGroup\NotFoundUrlLog\Api\LogRepositoryInterface;
use Magento\Framework\App\Router\NoRouteHandlerInterface;
use Psr\Log\LoggerInterface;
use TheSGroup\NotFoundUrlLog\Api\Data\LogInterface;
use Magento\Framework\App\State;
use Magento\Framework\App\Area;

/**
 * Class NoRouteHandler
 * Handler for not found url
 */
class NoRouteHandler implements NoRouteHandlerInterface
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var RemoteAddress
     */
    private $remoteAddress;

    /**
     * @var LogRepositoryInterface
     */
    private $logRepository;

    /**
     * @var LogInterfaceFactory
     */
    private $logInterfaceFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var State
     */
    private $state;

    /**
     * Constructor
     *
     * @param StoreManagerInterface $storeManager
     * @param RemoteAddress $remoteAddress
     * @param LogRepositoryInterface $logRepository
     * @param LogInterfaceFactory $logInterfaceFactory
     * @param LoggerInterface $logger
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param State $state
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        RemoteAddress $remoteAddress,
        LogRepositoryInterface $logRepository,
        LogInterfaceFactory $logInterfaceFactory,
        LoggerInterface $logger,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        State $state
    ) {
        $this->storeManager = $storeManager;
        $this->remoteAddress = $remoteAddress;
        $this->logRepository = $logRepository;
        $this->logInterfaceFactory = $logInterfaceFactory;
        $this->logger = $logger;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->state = $state;
    }

    /**
     * Process Request
     *
     * @param RequestInterface $request
     *
     * @return false
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function process(RequestInterface $request)
    {
        if ($this->state->getAreaCode() != Area::AREA_FRONTEND) {
            return false;
        }
        $requestUri = ltrim($request->getServer('REQUEST_URI'), '/');
        $storeId = (int) $this->storeManager->getStore()->getId();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(LogInterface::REQUEST_URL, $requestUri)
            ->addFilter(LogInterface::STORE_ID, $storeId)
            ->setPageSize(1)
            ->create();

        $searchResult = $this->logRepository->getList($searchCriteria);
        if ($searchResult->getTotalCount() > 0) {
            foreach ($searchResult->getItems() as $logEntry) {
                $logEntry->setOccurrences((int) $logEntry->getOccurrences() + 1);
                try {
                    $this->logRepository->save($logEntry);
                } catch (\Exception $e) {
                    $this->logger->error($e->getMessage());
                }
            }
            return false;
        }

        /** @var \TheSGroup\NotFoundUrlLog\Api\Data\LogInterface $logEntry */
        $logEntry = $this->logInterfaceFactory->create();
        $logEntry->setIp($this->remoteAddress->getRemoteAddress())
                 ->setReferUrl($request->getServer('HTTP_REFERER', ''))
                 ->setRequestUrl($requestUri)
                 ->setOccurrences(1)
                 ->setStoreId($storeId);
        try {
            $this->logRepository->save($logEntry);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return false;
    }
}
