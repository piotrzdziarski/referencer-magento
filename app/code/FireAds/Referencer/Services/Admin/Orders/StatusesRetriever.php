<?php

namespace FireAds\Referencer\Services\Admin\Orders;

use Magento\Framework\App\ResourceConnection;

class StatusesRetriever
{
    private $resourceConnection;

    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection->getConnection();
    }

    /**
     * Returns row from db with current status.
     * Example:
     * [
     *      'status' => 'canceled',
     *      'label' => 'Canceled'
     * ]
     *
     * If no current status:[
     * [
     *      'status' => '',
     *      'label' => 'All'
     * ]
     */
    public function getCurrentStatusRow()
    {
        $status = (isset($_GET['status'])) ? $_GET['status'] : null;

        if (!$status) {
            return [
                'status' => '',
                'label' => 'All'
            ];
        }

        $statusSelectQuery = $this->resourceConnection
            ->select()
            ->from('sales_order_status')
            ->where("status = '$status'");

        return $this->resourceConnection->fetchRow($statusSelectQuery);
    }

    public function getStatuses()
    {
        $statusesSelectQuery = $this->resourceConnection
            ->select()
            ->from('sales_order_status');

        return $this->resourceConnection->fetchAll($statusesSelectQuery);
    }
}
