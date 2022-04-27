<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */
declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface LogSearchResultsInterface
 */
interface LogSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get Log list.
     *
     * @return \TheSGroup\NotFoundUrlLog\Api\Data\LogInterface[]
     */
    public function getItems();

    /**
     * Set entity_id list.
     *
     * @param \TheSGroup\NotFoundUrlLog\Api\Data\LogInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
