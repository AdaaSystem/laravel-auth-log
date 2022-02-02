<?php

namespace Adaa\AuthLog;

trait EventMap
{
    /**
     * The Authentication Log event / listener mappings.
     *
     * @var array
     */
    protected $events = [
        'Illuminate\Auth\Events\Login' => [
            'Adaa\AuthLog\Listeners\LogSuccessfulLogin',
        ],

        'Illuminate\Auth\Events\Logout' => [
            'Adaa\AuthLog\Listeners\LogSuccessfulLogout',
        ],
    ];
}
