<?php

namespace FireAds\Referencer\Services\Admin\Orders;

use Magento\Framework\App\ResourceConnection;

class OrdersRetriever
{
    public $status;
    public $dateFrom;
    public $dateTo;

    private $resourceConnection;

    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection->getConnection();
    }

    /**
     * @uses OrdersRetriever::$status, OrdersRetriever::$dateFrom, OrdersRetriever::$dateTo
     */
    public function getSearchedOrdersCount()
    {
        $ordersSelectQuery = $this->getConditionedWithStatusAndDateSelect('COUNT(entity_id)');
        return $this->resourceConnection->fetchOne($ordersSelectQuery);
    }

    /**
     * @uses OrdersRetriever::$status, OrdersRetriever::$dateFrom, OrdersRetriever::$dateTo
     */
    public function getOrdersForPage($page)
    {
        $conditionedSelect = $this->getConditionedWithStatusAndDateSelect();
        $conditionedSelect
            ->limit(20, ($page - 1) * 20)
            ->order('entity_id DESC');

        return $this->resourceConnection->fetchAll($conditionedSelect);
    }

    private function getConditionedWithStatusAndDateSelect($cols = '*')
    {
        $select = $this->resourceConnection->select()
            ->from('sales_order', $cols)
            ->where('fireads_key IS NOT NULL');

        if ($this->status) {
            $select->where("status = '$this->status'");
        }

        if ($this->dateFrom) {
            $select->where("created_at > '$this->dateFrom'");
        }

        if ($this->dateTo) {
            $select->where("created_at < '$this->dateTo'");
        }

        return $select;
    }
}
