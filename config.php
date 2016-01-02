<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 02.01.2016
 * Time: 20:26
 */
$config = [
    'databases' => [
        'db_vktest' => [
            'host' => '127.0.0.1',
            'user' => 'root',
            'password' => 'rootpass',
            'port' => 3306
        ]
    ],
    'route'=>[
        '/^\/$/i' =>[
            'type' => 'GET',
            'action' => 'homeAction'
        ],
        '^/insert$' =>[
            'type' => 'GET',
            'action' => ''
            ],
        '^/update$' => [
            'type' => 'GET',
            'action' => ''
        ]
    ]
];