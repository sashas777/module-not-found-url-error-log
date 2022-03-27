<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */
declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Model;

use Magento\Framework\Model\AbstractModel;
use TheSGroup\NotFoundUrlLog\Api\Data\LogInterface;
use TheSGroup\NotFoundUrlLog\Model\ResourceModel\Log as ResourceModel;

/**
 * Class Log
 */
class Log extends AbstractModel implements LogInterface
{
    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inheritDoc
     */
    public function getEntityId()
    {
        return $this->getData(static::ENTITY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setEntityId($entityId): LogInterface
    {
        return $this->setData(static::ENTITY_ID, $entityId);
    }

    /**
     * @inheritDoc
     */
    public function getRequestUrl()
    {
        return $this->getData(static::REQUEST_URL);
    }

    /**
     * @inheritDoc
     */
    public function setRequestUrl($requestUrl): LogInterface
    {
        return $this->setData(static::REQUEST_URL, $requestUrl);
    }

    /**
     * @inheritDoc
     */
    public function getReferUrl()
    {
        return $this->getData(static::REFER_URL);
    }

    /**
     * @inheritDoc
     */
    public function setReferUrl($referUrl): LogInterface
    {
        return $this->setData(static::REFER_URL, $referUrl);
    }

    /**
     * @inheritDoc
     */
    public function getIp()
    {
        return $this->getData(static::IP);
    }

    /**
     * @inheritDoc
     */
    public function setIp($ip): LogInterface
    {
        return $this->setData(static::IP, $ip);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt()
    {
        return $this->getData(static::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt($createdAt): LogInterface
    {
        return $this->setData(static::CREATED_AT, $createdAt);
    }

    /**
     * @inheritDoc
     */
    public function getStoreId()
    {
        return $this->getData(static::STORE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setStoreId($storeId): LogInterface
    {
        return $this->setData(static::STORE_ID, $storeId);
    }
}

