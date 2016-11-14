<?php

return [
    'components' => [
        'db' => [
            'className' => \components\Database::class,
            'params' => include 'dbparams.php',
        ],
        'flashMessages' => [
            'className' => \components\FlashMessage::class,
        ],
        'request' => [
            'className' => \components\Request::class,
        ],
        'session' => [
            'className' => \components\Session::class,
        ],
        'urlManager' => [
            'className' => \components\UrlManager::class,
        ],
        'user' => [
            'className' => \components\User::class,
        ],
    ],
];