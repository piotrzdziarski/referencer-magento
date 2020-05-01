<?php

namespace FireAds\Referencer\Model\ResourceModel\Activity;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'fireads_activities_collection';
    protected $_eventObject = 'activity_collection';

    protected function _construct()
    {
        $this->_init('FireAds\Referencer\Model\Activity', 'FireAds\Referencer\Model\ResourceModel\Activity');
    }
}
