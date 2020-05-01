<?php

namespace FireAds\Referencer\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use FireAds\Referencer\Services\GlobalArrayConditioner;
use FireAds\Referencer\Services\Activity\ActivityActioner;
use FireAds\Referencer\Services\RedirectActioner;

class PageLoadObserver implements ObserverInterface
{
    private $globalArrayConditioner;
    private $activityActioner;
    private $redirectActioner;

    public function __construct(GlobalArrayConditioner $globalArrayConditioner, ActivityActioner $activityActioner, RedirectActioner $redirectActioner)
    {
        $this->globalArrayConditioner = $globalArrayConditioner;
        $this->activityActioner = $activityActioner;
        $this->redirectActioner = $redirectActioner;
    }

    public function execute(Observer $observer)
    {
        if ($this->globalArrayConditioner->isFireAdsKeyGetParamSetAndValid()) {
            $this->redirectActioner->runActions();
        } elseif ($this->globalArrayConditioner->isFireAdsClientIdCookieSetAndValid()) {
            $this->activityActioner->runOldFireAdsClientActions();
        }
    }
}
