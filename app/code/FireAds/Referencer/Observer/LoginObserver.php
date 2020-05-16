<?php

namespace FireAds\Referencer\Observer;

use FireAds\Referencer\Services\Auth\AuthActioner;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class LoginObserver implements ObserverInterface
{
    private $authActioner;

    public function __construct(AuthActioner $authActioner)
    {
        $this->authActioner = $authActioner;
    }

    public function execute(Observer $observer)
    {
        $customerId = $observer->getEvent()->getCustomer()->getId();
        $this->authActioner->ifKeyCookieIsValidUpdateFireAdsKeyMetaForUserId($customerId);
    }
}
