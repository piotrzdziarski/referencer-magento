<?php

namespace FireAds\Referencer\Services\Activity;

use FireAds\Referencer\Services\CookieManager;

class ActivityActioner
{
    private $activityDbManager;
    private $cookieManager;

    public function __construct(ActivityDbManager $activityDbManager, CookieManager $cookieManager)
    {
        $this->activityDbManager = $activityDbManager;
        $this->cookieManager = $cookieManager;
    }

    public function runNewFireAdsClientActions()
    {
        $this->cookieManager->setCookie(
            'fireAdsClientId',
            $this->activityDbManager->storeNewActivityToDbAndGetId()
        );
    }

    public function runOldFireAdsClientActions()
    {
        ($this->activityDbManager->doesActivityRecordWithIdExists($_COOKIE['fireads-client-id'])) ?
            $this->activityDbManager->incrementTotalEntries() :
            $this->cookieManager->deleteCookie('fireAdsClientId');
    }
}
