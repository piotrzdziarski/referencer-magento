<?php

namespace FireAds\Referencer\Controller\Adminhtml\Settings;

use FireAds\Referencer\Services\ConfigRetriever;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    private $resultPageFactory;
    private $configRetriever;

    public function __construct(Context $context, PageFactory $resultPageFactory, ConfigRetriever $configRetriever)
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->configRetriever = $configRetriever;
        parent::__construct($context);
    }

    public function execute()
    {
        $page = $this->resultPageFactory->create();

        $block = $page->getLayout()->getBlock('main');
        $block->setData('fireads-postback-url', $this->configRetriever->getConfigValueByPath('fireads/postback_url'));
        $block->setData('fireads-procent', $this->configRetriever->getConfigValueByPath('fireads/procent'));

        return $page;
    }
}
