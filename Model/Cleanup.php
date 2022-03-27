<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */
declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Model;

use TheSGroup\NotFoundUrlLog\Model\ResourceModel\Log\CollectionFactory;

/**
 * Class Cleanup
 */
class Cleanup
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param $lifetimeMinutes
     *
     * @return void
     */
    public function execute($lifetimeMinutes = 0)
    {
        /** @var \TheSGroup\NotFoundUrlLog\Model\ResourceModel\Log\Collection $collection */
        $collection = $this->collectionFactory->create();
        $connection= $collection->getResource()->getConnection();

        if ($lifetimeMinutes) {
            $collection
                ->addFieldToSelect('entity_id')
                ->addFieldToFilter(
                    'created_at',
                    ['lteq' =>  new \Zend_Db_Expr('CURRENT_TIMESTAMP - INTERVAL '.$lifetimeMinutes.' MINUTE')]
                );
            $oldEntityIds = $collection->getAllIds();
            if (count($oldEntityIds)) {
                $connection->delete(
                    $connection->getTableName('tsg_404_log'),
                    'entity_id IN ('.implode(',', $oldEntityIds).')'
                );
            }
        } else {
            $connection->truncateTable($connection->getTableName('tsg_404_log'));
        }
    }
}
