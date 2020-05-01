<?php

namespace FireAds\Referencer\Controller\Adminhtml\Settings;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Controller\Result\RedirectFactory;

class Save extends Action
{
    private $configWriter;
    private $redirectFactory;

    public function __construct(Context $context, WriterInterface $configWriter, RedirectFactory $redirectFactory)
    {
        $this->configWriter = $configWriter;
        $this->redirectFactory = $redirectFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $this->configWriter->save('fireads/postback_url', $_POST['postback-url'], ScopeConfigInterface::SCOPE_TYPE_DEFAULT, 0);
        $this->configWriter->save('fireads/procent', $_POST['procent'], ScopeConfigInterface::SCOPE_TYPE_DEFAULT, 0);

        $redirect = $this->redirectFactory->create();
        $redirect->setPath('fireads/settings');

        return $redirect;
    }
}
