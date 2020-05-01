<?php

namespace FireAds\Referencer\Observer;

use FireAds\Referencer\Services\GlobalArrayConditioner;
use FireAds\Referencer\Services\ReferenceKeyManager;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\ResourceModel\Order as OrderResource;

class OrderSubmitObserver implements ObserverInterface
{
    private $referenceKeyManager;
    private $globalArrayConditioner;
    private $orderResource;
    private $authSession;

    private $fireAdsKey;
    private $order;

    public function __construct(ReferenceKeyManager $referenceKeyManager, GlobalArrayConditioner $globalArrayConditioner, OrderResource $orderResource, Session $authSession)
    {
        $this->referenceKeyManager = $referenceKeyManager;
        $this->globalArrayConditioner = $globalArrayConditioner;
        $this->orderResource = $orderResource;
        $this->authSession = $authSession;
    }

    public function execute(Observer $observer)
    {
        $this->order = $observer->getEvent()->getOrder();

        $this->fireAdsKey = $this->referenceKeyManager->getReferenceKeyFromCustomerById($this->order->getCustomerId());

        if ($this->fireAdsKey) {
            $this->saveFireAdsKeyToOrder();
            return;
        }

        if ($this->globalArrayConditioner->isFireAdsKeyCookieSetAndValid()) {
            $this->fireAdsKey = $_COOKIE['fireads-key'];
            $this->saveFireAdsKeyToOrder();
        }
    }

    private function saveFireAdsKeyToOrder()
    {
        $this->order->setData('fireads_key', $this->fireAdsKey);
        $this->orderResource->save($this->order);
    }
}
