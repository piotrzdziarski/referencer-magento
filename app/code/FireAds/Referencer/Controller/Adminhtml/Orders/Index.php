<?php

namespace FireAds\Referencer\Controller\Adminhtml\Orders;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    private $resultPageFactory;

    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $page = $this->resultPageFactory->create();

        $block = $page->getLayout()->getBlock('main');
//        $block->setData('fireads-postback-url', $this->configRetriever->getConfigValueByPath('fireads/postback_url'));
//        $block->setData('fireads-procent', $this->configRetriever->getConfigValueByPath('fireads/procent'));

        return $page;
    }
}
