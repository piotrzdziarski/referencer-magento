<?php

namespace FireAds\Referencer\Services\Auth;

use FireAds\Referencer\Services\Activity\ActivityDbManager;
use FireAds\Referencer\Services\GlobalArrayConditioner;
use Magento\Reports\Model\ResourceModel\Customer\Collection;

class AuthActioner
{
    private $globalArrayConditioner;
    private $activityDbManager;
    private $customerCollection;

    public function __construct(
        GlobalArrayConditioner $globalArrayConditioner,
        ActivityDbManager $activityDbManager,
        Collection $customerCollection
    ) {
        $this->globalArrayConditioner = $globalArrayConditioner;
        $this->activityDbManager = $activityDbManager;
        $this->customerCollection = $customerCollection;
    }

    public function ifKeyCookieIsValidUpdateFireAdsKeyMetaForUserId($userId)
    {
        if ($this->globalArrayConditioner->isFireAdsKeyCookieSetAndValid()) {
            $this->updateFireAdsKeyMetaForUserId($userId);
        }
    }

    public function updateFireAdsKeyMetaForUserId($userId)
    {
        $customer = $this->customerCollection->getItemById($userId);
        $customer->setData('fireads_key', $_COOKIE['fireads-key']);
        $this->customerCollection->save();
    }

    public function ifClientIdCookieIsValidAndRowIsInDbUpdatedHasRegistered()
    {
        if ($this->globalArrayConditioner->isFireAdsClientIdCookieSetAndValid()
            && $this->activityDbManager->doesActivityRecordWithIdExists($_COOKIE['fireads-client-id'])) {
            $this->activityDbManager->updateHasRegisteredBooleanToTrue();
        }
    }
}
