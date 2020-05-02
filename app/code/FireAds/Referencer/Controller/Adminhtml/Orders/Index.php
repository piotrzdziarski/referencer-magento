<?php

namespace FireAds\Referencer\Controller\Adminhtml\Orders;

use FireAds\Referencer\Services\Admin\Orders\DateRangeRetriever;
use FireAds\Referencer\Services\Admin\Orders\OrdersPaginator;
use FireAds\Referencer\Services\Admin\Orders\OrdersRetriever;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    private $resultPageFactory;
    private $dateRangeRetriever;
    private $ordersRetriever;
    private $ordersPaginator;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        DateRangeRetriever $dateRangeRetriever,
        OrdersRetriever $ordersRetriever,
        OrdersPaginator $ordersPaginator
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->dateRangeRetriever = $dateRangeRetriever;
        $this->ordersRetriever = $ordersRetriever;
        $this->ordersPaginator = $ordersPaginator;
        parent::__construct($context);
    }

    public function execute()
    {
        $page = $this->resultPageFactory->create();
        $block = $page->getLayout()->getBlock('main');

        $status = (isset($_GET['status'])) ? $_GET['status'] : null;
        $dateFrom = $this->dateRangeRetriever->getFromDate();
        $dateTo = $this->dateRangeRetriever->getToDate();
        $this->ordersRetriever->status = $status;
        $this->ordersRetriever->dateFrom = $dateFrom;
        $this->ordersRetriever->dateTo = $dateTo;
        $searchedOrdersCount = $this->ordersRetriever->getSearchedOrdersCount();
        $pagesCount = $this->ordersPaginator->getPagesCount($searchedOrdersCount);
        $currentPage = $this->ordersPaginator->getCurrentPage();
        $pageOrders = $this->ordersRetriever->getOrdersForPage($currentPage);

        $block->setData('status', $status);
        $block->setData('date-from', $dateFrom);
        $block->setData('date-to', $dateTo);
        $block->setData('searched-orders-count', $searchedOrdersCount);
        $block->setData('pages-count', $pagesCount);
        $block->setData('current-page', $currentPage);
        $block->setData('page-orders', $pageOrders);

        return $page;
    }
}
