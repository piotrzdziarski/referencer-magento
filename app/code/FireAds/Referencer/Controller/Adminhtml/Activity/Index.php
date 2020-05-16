<?php

namespace FireAds\Referencer\Controller\Adminhtml\Activity;

use FireAds\Referencer\Services\Admin\Activity\ActivityDataRetriever;
use FireAds\Referencer\Services\Admin\Activity\TimesRangesProducer;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    private $resultPageFactory;
    private $timesRangesProducer;
    private $activityDataRetriever;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        TimesRangesProducer $timesRangesProducer,
        ActivityDataRetriever $activityDataRetriever
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->timesRangesProducer = $timesRangesProducer;
        $this->activityDataRetriever = $activityDataRetriever;
        parent::__construct($context);
    }

    public function execute()
    {
        $page = $this->resultPageFactory->create();
        $block = $page->getLayout()->getBlock('main');
        $currentMonthRow = $this->timesRangesProducer->getCurrentMonthRow();
        $currentYear = $this->timesRangesProducer->getCurrentYear();

        $block->setData('current-month-row', $currentMonthRow);
        $block->setData('months', $this->timesRangesProducer->getMonths());
        $block->setData('current-year', $currentYear);
        $block->setData('years', $this->timesRangesProducer->getYears());
        $block->setData(
            'activity-data',
            $this->activityDataRetriever->getActivityData($currentMonthRow['index'] + 1, $currentYear)
        );

        return $page;
    }
}
