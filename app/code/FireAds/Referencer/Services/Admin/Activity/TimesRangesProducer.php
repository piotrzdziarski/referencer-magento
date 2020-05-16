<?php

namespace FireAds\Referencer\Services\Admin\Activity;

class TimesRangesProducer
{
    const months = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ];

    /**
     * Return array with label and index of month:
     * [
     *      'index' => 2
     *      'label' => 'March',
     * ]
     */
    public function getCurrentMonthRow()
    {
        if (!isset($_GET['month'])) {
            return [
                'index' => array_search(date('M'), self::months),
                'label' => date('M')
            ];
        }

        return [
            'index' => $_GET['month'],
            'label' => self::months[$_GET['month']]
        ];
    }

    public function getMonths()
    {
        return self::months;
    }

    public function getCurrentYear()
    {
        return (isset($_GET['year'])) ? $_GET['year'] : date('Y');
    }

    public function getYears()
    {
        $years = [];
        $currentYear = (int)date('Y');

        for ($i = $currentYear; $i > $currentYear - 100; $i--) {
            array_push($years, $i);
        }

        return $years;
    }
}
