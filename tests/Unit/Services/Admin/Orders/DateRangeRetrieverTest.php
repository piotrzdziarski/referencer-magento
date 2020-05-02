<?php

namespace FireAds\Referencer\Services\Admin\Orders;

use Tests\Unit\TestCase;

class DateRangeRetrieverTest extends TestCase
{
    public function testGetRange()
    {
        $completedOrdersPageDataBuilder = new DateRangeRetriever();
        $_GET['date-from'] = strtotime('2010-10-30') . 'a';
        $_GET['date-to'] = strtotime('2010-10-30');
        $this->assertNull($completedOrdersPageDataBuilder->getFromDate());
        $this->assertEquals('2010-10-30', $completedOrdersPageDataBuilder->getToDate());

        $_GET['date-from'] = strtotime('2005-10-15');
        $_GET['date-to'] = ';' . strtotime('2001-02-10');
        $this->assertEquals('2005-10-15', $completedOrdersPageDataBuilder->getFromDate());
        $this->assertNull($completedOrdersPageDataBuilder->getToDate());
    }
}
