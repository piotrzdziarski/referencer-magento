<?php

namespace FireAds\Referencer\Services\Activity;

use FireAds\Referencer\Model\Activity;
use FireAds\Referencer\Model\ResourceModel\Activity as ActivityResource;
use FireAds\Referencer\Model\ResourceModel\Activity\Collection;

class ActivityDbManager
{
    private $activity;
    private $activityResource;
    private $activityCollection;

    public function __construct(Activity $activity, ActivityResource $activityResource, Collection $activityCollection)
    {
        $this->activity = $activity;
        $this->activityResource = $activityResource;
        $this->activityCollection = $activityCollection;
    }

    public function storeNewActivityToDbAndGetId()
    {
        $this->activity->setData([
            'date_add' => date('Y-m-d H:i:s'),
            'total_entries' => 1,
            'has_registered' => false
        ]);
        $this->activityResource->save($this->activity);

        return $this->activity->getId();
    }

    public function doesActivityRecordWithIdExists($id)
    {
        return !!$this->activityCollection->getItemById($id);
    }

    public function updateHasRegisteredBooleanToTrue()
    {
        $activity = $this->activityCollection->getItemById($_COOKIE['fireads-client-id']);
        $activity->setData('has_registered', true);
        $this->activityCollection->save();
    }

    public function incrementTotalEntries()
    {
        $activity = $this->activityCollection->getItemById($_COOKIE['fireads-client-id']);
        $activity->setData('total_entries', (int)$activity->getData('total_entries') + 1);
        $this->activityCollection->save();
    }
}
