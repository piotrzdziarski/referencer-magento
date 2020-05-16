<?php

namespace FireAds\Referencer\Services\Admin\Activity;

use Magento\Framework\App\ResourceConnection;

class ActivityDataRetriever
{
    private $resourceConnection;

    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection->getConnection();
    }

    /**
     * Return activity data for specify month in array. Example:
     * [
     *      'unique-entries' => 5,
     *      'registered-users' => 10,
     *      'total-entries' => 24
     * ]
     */
    public function getActivityData($month, $year)
    {
        $data = [
            'unique-entries' => 0,
            'registered-users' => 0,
            'total-entries' => 0
        ];

        $activitiesSelectQuery = $this->resourceConnection
            ->select()
            ->from('fireads_activities')
            ->where("MONTH(created_at) = $month")
            ->where("YEAR(created_at) = $year");

        $activities = $this->resourceConnection->fetchAll($activitiesSelectQuery);

        $data['unique-entries'] = count($activities);

        foreach ($activities as $activity) {
            if ($activity['has_registered']) {
                $data['registered-users'] += 1;
            }

            $data['total-entries'] += $activity['total_entries'];
        }

        return $data;
    }
}
