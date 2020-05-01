<?php

namespace FireAds\Referencer\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use FireAds\Referencer\Services\PostbackSender;

class OrderStatusChangeObserver implements ObserverInterface
{
    private $postbackSender;

    public function __construct(PostbackSender $postbackSender)
    {
        $this->postbackSender = $postbackSender;
    }

    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();

        $state = $order->getState();
        if ($state == 'new') {
            return;
        }

        $fireAdsKey = $order->getFireadsKey();
        if (!$fireAdsKey) {
            return;
        }

        $this->postbackSender->sendPostback($order, $fireAdsKey);
    }
}
