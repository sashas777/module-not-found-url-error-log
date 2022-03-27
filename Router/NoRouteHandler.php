<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */
declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Router;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Store\Model\StoreManagerInterface;
use TheSGroup\NotFoundUrlLog\Api\Data\LogInterfaceFactory;
use TheSGroup\NotFoundUrlLog\Api\LogRepositoryInterface;
use Magento\Framework\App\Router\NoRouteHandlerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class NoRouteHandler
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
     * @param StoreManagerInterface $storeManager
     * @param RemoteAddress $remoteAddress
     * @param LogRepositoryInterface $logRepository
     * @param LogInterfaceFactory $logInterfaceFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        RemoteAddress $remoteAddress,
        LogRepositoryInterface $logRepository,
        LogInterfaceFactory $logInterfaceFactory,
         LoggerInterface $logger
    ) {
        $this->storeManager = $storeManager;
        $this->remoteAddress = $remoteAddress;
        $this->logRepository = $logRepository;
        $this->logInterfaceFactory = $logInterfaceFactory;
        $this->logger = $logger;
    }

    /**
     * @param RequestInterface $request
     *
     * @return false
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function process(RequestInterface $request)
    {
        /** @var \TheSGroup\NotFoundUrlLog\Api\Data\LogInterface $logEntry */
        $logEntry = $this->logInterfaceFactory->create();
        $logEntry->setIp($this->remoteAddress->getRemoteAddress())
            ->setReferUrl($request->getServer('HTTP_REFERER', ''))
            ->setRequestUrl($request->getServer('REQUEST_URI'))
            ->setStoreId($this->storeManager->getStore()->getId());
        try {
            $this->logRepository->save($logEntry);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return false;
    }
}
