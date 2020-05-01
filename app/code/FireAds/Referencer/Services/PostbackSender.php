<?php

namespace FireAds\Referencer\Services;

use Magento\Framework\HTTP\Client\Curl;
use Exception;

class PostbackSender
{
    private $configRetriever;
    private $curl;

    public function __construct(ConfigRetriever $configRetriever, Curl $curl)
    {
        $this->configRetriever = $configRetriever;
        $this->curl = $curl;
    }

    /**
     * @param $order \Magento\Sales\Model\Order
     * @param $referenceKey string
     */
    public function sendPostback($order, $referenceKey)
    {
        $postbackUrl = $this->configRetriever->getConfigValueByPath('fireads/postback_url');
        if (!$postbackUrl) {
            die('FireAds postback URL not set!');
        }

        $floatProcent = (float)$this->configRetriever->getConfigValueByPath('fireads/procent') / 100;
        $postData = [
            'status' => null,
            'orderId' => $order->getId(),
            'currency' => $order->getStoreCurrencyCode(),
            'key' => $referenceKey,
            'value' => $floatProcent * $order->getBaseGrandTotal()
        ];
        switch ($order->getStatus()) {
            case 'canceled':
            case 'closed':
            case 'fraud':
                $postData['status'] = -1;
                break;
            case 'complete':
                $postData['status'] = 1;
                break;
            default:
                $postData['status'] = 0;
                break;
        }

        try {
            $this->curl->post($postbackUrl, $postData);
        } catch (Exception $e) {
            die('FireAds Referencer error: ' . $e->getMessage());
        }
    }
}
