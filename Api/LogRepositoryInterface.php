<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */
declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use TheSGroup\NotFoundUrlLog\Api\Data\LogInterface;

/**
 * Interface LogRepositoryInterface
 */
interface LogRepositoryInterface
{
    /**
     * Save Log
     * @param \TheSGroup\NotFoundUrlLog\Api\Data\LogInterface $log
     * @return \TheSGroup\NotFoundUrlLog\Api\Data\LogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(LogInterface $log);

    /**
     * Retrieve Log
     * @param string $logId
     * @return \TheSGroup\NotFoundUrlLog\Api\Data\LogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($logId);

    /**
     * Retrieve Log matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \TheSGroup\NotFoundUrlLog\Api\Data\LogSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Log
     * @param \TheSGroup\NotFoundUrlLog\Api\Data\LogInterface $log
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(LogInterface $log);

    /**
     * Delete Log by ID
     * @param string $logId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($logId);
}
