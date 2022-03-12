<?php
    return [
        'type' => [
            1 => 'Every',
            2 => 'Every Other',
            3 => 'Every Third',
            4 => 'Every Fourth'
        ],
        'frequency' => [
            1 => 'Day',
            2 => 'Week',
            3 => 'Month',
            4 => 'Year'
        ],

        'include_last_occrence' => env('INCLUDE_LAST_OCCRENCE', true),
    ];