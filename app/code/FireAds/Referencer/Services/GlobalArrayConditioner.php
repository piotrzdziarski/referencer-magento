<?php

namespace FireAds\Referencer\Services;

class GlobalArrayConditioner
{
    public function isFireAdsKeyGetParamSetAndValid()
    {
        return $this->isKeyFromGlobalArrayAlphanumeric('key', $_GET);
    }

    public function isFireAdsKeyCookieSetAndValid()
    {
        return $this->isKeyFromGlobalArrayAlphanumeric('fireads-key', $_COOKIE);
    }

    public function isFireAdsClientIdCookieSetAndValid()
    {
        return isset($_COOKIE['fireads-client-id']) && is_numeric($_COOKIE['fireads-client-id']);
    }

    private function isKeyFromGlobalArrayAlphanumeric($key, &$globalArray)
    {
        return isset($globalArray[$key]) && preg_match('/^\w+$/', $globalArray[$key]);
    }
}
