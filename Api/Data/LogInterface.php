<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */
declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Api\Data;

interface LogInterface
{
    const ENTITY_ID = 'entity_id';
    const STORE_ID = 'store_id';
    const CREATED_AT = 'created_at';
    const IP = 'ip';
    const REQUEST_URL = 'request_url';
    const REFER_URL = 'refer_url';
    const UPDATED_AT = 'updated_at';
    const OCCURRENCES = 'occurrences';

    /**
     * Get entity_id
     * @return string|null
     */
    public function getEntityId();

    /**
     * Set entity_id
     *
     * @param string $entityId
     *
     * @return \TheSGroup\NotFoundUrlLog\Log\Api\Data\LogInterface
     */
    public function setEntityId($entityId): LogInterface;

    /**
     * Get request_url
     * @return string|null
     */
    public function getRequestUrl();

    /**
     * Set request_url
     *
     * @param string $requestUrl
     *
     * @return \TheSGroup\NotFoundUrlLog\Log\Api\Data\LogInterface
     */
    public function setRequestUrl(string $requestUrl): LogInterface;

    /**
     * Get refer_url
     * @return string|null
     */
    public function getReferUrl();

    /**
     * Set refer_url
     *
     * @param ?string $referUrl
     *
     * @return \TheSGroup\NotFoundUrlLog\Log\Api\Data\LogInterface
     */
    public function setReferUrl(?string $referUrl): LogInterface;

    /**
     * Get ip
     * @return string|null
     */
    public function getIp();

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return \TheSGroup\NotFoundUrlLog\Log\Api\Data\LogInterface
     */
    public function setIp(string $ip): LogInterface;

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     *
     * @param string $createdAt
     *
     * @return \TheSGroup\NotFoundUrlLog\Log\Api\Data\LogInterface
     */
    public function setCreatedAt(string $createdAt): LogInterface;

    /**
     * Get updated_at
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated_at
     *
     * @param string $updatedAt
     *
     * @return \TheSGroup\NotFoundUrlLog\Log\Api\Data\LogInterface
     */
    public function setUpdatedAt(string $updatedAt): LogInterface;

    /**
     * Get store_id
     * @return string|null
     */
    public function getStoreId();

    /**
     * Set store_id
     *
     * @param int $storeId
     *
     * @return \TheSGroup\NotFoundUrlLog\Log\Api\Data\LogInterface
     */
    public function setStoreId(int $storeId): LogInterface;

    /**
     * Get occurrences
     * @return string|null
     */
    public function getOccurrences();

    /**
     * Set occurrences
     *
     * @param int $occurrences
     *
     * @return \TheSGroup\NotFoundUrlLog\Log\Api\Data\LogInterface
     */
    public function setOccurrences(int $occurrences): LogInterface;
}

