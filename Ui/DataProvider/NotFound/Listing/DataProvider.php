<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */
declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Ui\DataProvider\NotFound\Listing;

use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider as MagentoDataProvider;

/**
 * Class DataProvider
 * Not found log data provider
 */
class DataProvider extends MagentoDataProvider
{
    /**
     * @inheritdoc
     */
    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {
        if ($filter->getField() == 'redirect_exists') {
            $filter->setField('url_rewrite_id');
            if ($filter->getValue() == 1) {
                $filter->setConditionType('gt');
                $filter->setValue(0);
            } else {
                $filter->setConditionType('null');
            }
        }

        return parent::addFilter($filter);
    }

    /**
     * @inheritdoc
     */
    public function getSearchResult()
    {
        $result = parent::getSearchResult();
        $result->getSelect()->joinLeft(
            ['ur' => $result->getConnection()->getTableName('url_rewrite')],
            'ur.request_path = main_table.request_url AND ur.store_id = main_table.store_id',
            ['redirect_exists' => new \Zend_Db_Expr('IF (ur.url_rewrite_id > 0, 1, 0) ')]
        );

        return $result;
    }
}
