<?php

namespace FireAds\Referencer\Services;

use Magento\Config\Model\ResourceModel\Config\Data\Collection;

class ConfigRetriever
{
    private $configCollection;

    public function __construct(Collection $configCollection)
    {
        $this->configCollection = $configCollection;
    }

    public function getConfigValueByPath($path)
    {
        return $this->configCollection->getItemByColumnValue('path', $path)->getData('value');
    }
}
