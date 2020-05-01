<?php

namespace FireAds\Referencer\Services;

use Magento\Customer\Model\ResourceModel\Customer\Collection;

class ReferenceKeyManager
{
    private $customerCollection;

    public function __construct(Collection $customerCollection)
    {
        $this->customerCollection = $customerCollection;
    }

    public function getReferenceKeyFromCustomerById($customerId)
    {
        $customer = $this->customerCollection->getItemById($customerId);
        return $customer->getData('fireads_key');
    }
}
