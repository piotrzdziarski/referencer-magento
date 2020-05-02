<?php

namespace FireAds\Referencer\Services\Admin\Orders;

class OrdersPaginator
{
    private $pagesCount;

    public function getPagesCount($ordersCount)
    {
        $this->pagesCount = ceil($ordersCount / 20);
        return $this->pagesCount;
    }

    /**
     * @uses OrdersPaginator::getPagesCount() result
     */
    public function getCurrentPage()
    {
        $currentPage = 1;

        if (isset($_GET['page-number']) && is_numeric($_GET['page-number'])) {
            $currentPage = (int)$_GET['page-number'];

            if ($currentPage > $this->pagesCount) {
                $currentPage = $this->pagesCount;
            }
        }

        return $currentPage;
    }
}
