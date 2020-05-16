<?php

namespace FireAds\Referencer\Observer;

use FireAds\Referencer\Services\Auth\AuthActioner;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class RegisterObserver implements ObserverInterface
{
    private $authActioner;

    public function __construct(AuthActioner $authActioner)
    {
        $this->authActioner = $authActioner;
    }

    public function execute(Observer $observer)
    {
        $userId = $observer->getEvent()->getCustomer()->getId();
        $this->authActioner->ifKeyCookieIsValidUpdateFireAdsKeyMetaForUserId($userId);
        $this->authActioner->ifClientIdCookieIsValidAndRowIsInDbUpdatedHasRegistered();
    }
}
