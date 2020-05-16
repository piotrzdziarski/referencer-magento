<?php

namespace FireAds\Referencer\Services\Auth;

use FireAds\Referencer\Services\Activity\ActivityDbManager;
use FireAds\Referencer\Services\GlobalArrayConditioner;
use Magento\Framework\App\ResourceConnection;

class AuthActioner
{
    private $globalArrayConditioner;
    private $activityDbManager;
    private $resourceConnection;

    public function __construct(
        GlobalArrayConditioner $globalArrayConditioner,
        ActivityDbManager $activityDbManager,
        ResourceConnection $resourceConnection
    ) {
        $this->globalArrayConditioner = $globalArrayConditioner;
        $this->activityDbManager = $activityDbManager;
        $this->resourceConnection = $resourceConnection->getConnection();
    }

    public function ifKeyCookieIsValidUpdateFireAdsKeyMetaForUserId($customerId)
    {
        if ($this->globalArrayConditioner->isFireAdsKeyCookieSetAndValid()) {
            $this->updateFireAdsKeyForCustomerId($customerId);
        }
    }

    public function updateFireAdsKeyForCustomerId($customerId)
    {
        $this->resourceConnection->update('customer_entity', [
            'fireads_key' => $_COOKIE['fireads-key']
        ], "entity_id = $customerId");
    }

    public function ifClientIdCookieIsValidAndRowIsInDbUpdatedHasRegistered()
    {
        if ($this->globalArrayConditioner->isFireAdsClientIdCookieSetAndValid()
            && $this->activityDbManager->doesActivityRecordWithIdExists($_COOKIE['fireads-client-id'])) {
            $this->activityDbManager->updateHasRegisteredBooleanToTrue();
        }
    }
}
