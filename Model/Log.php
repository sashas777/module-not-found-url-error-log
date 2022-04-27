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
    public function setRequestUrl(string $requestUrl): LogInterface
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
    public function setReferUrl(?string $referUrl): LogInterface
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
    public function setIp(string $ip): LogInterface
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
    public function setCreatedAt(string $createdAt): LogInterface
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
    public function setStoreId(int $storeId): LogInterface
    {
        return $this->setData(static::STORE_ID, $storeId);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt()
    {
        return $this->getData(static::UPDATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setUpdatedAt(string $updatedAt): LogInterface
    {
        return $this->setData(static::UPDATED_AT, $updatedAt);
    }

    /**
     * @inheritDoc
     */
    public function getOccurrences()
    {
        return $this->getData(static::OCCURRENCES);
    }

    /**
     * @inheritDoc
     */
    public function setOccurrences(int $occurrences): LogInterface
    {
        return $this->setData(static::OCCURRENCES, $occurrences);
    }
}
