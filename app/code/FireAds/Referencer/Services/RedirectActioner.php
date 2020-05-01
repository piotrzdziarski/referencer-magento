<?php

namespace FireAds\Referencer\Services;

use FireAds\Referencer\Services\Activity\ActivityActioner;
use FireAds\Referencer\Services\Auth\AuthActioner;
use Magento\Customer\Model\Session;

class RedirectActioner
{
    private $authActioner;
    private $activityActions;
    private $cookieManager;
    private $userSession;

    public function __construct(
        CookieManager $cookieManager,
        AuthActioner $authActioner,
        ActivityActioner $activityActions,
        Session $userSession
    ) {
        $this->cookieManager = $cookieManager;
        $this->authActioner = $authActioner;
        $this->activityActions = $activityActions;
        $this->userSession = $userSession;
    }

    public function runActions()
    {
        $this->cookieManager->setCookie('fireads-key', $_GET['key']);

        if ($this->userSession->isLoggedIn()) {
            $this->authActioner->updateFireAdsKeyMetaForUserId($this->userSession->getId());
        }

        if (!isset($_COOKIE['fireads-client-id'])) {
            $this->activityActions->runNewFireAdsClientActions();
        }

        if (!empty($_GET['deep-link'])) {
            header('Location: ' . $_GET['deep-link']);
            exit;
        }
    }
}
