<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 02.01.2016
 * Time: 20:26
 */
$config = [
    '__ROOTDIR__' => __DIR__,
    'databases' => [
        'db_vktest' => [
            'host' => '127.0.0.1',
            'user' => 'root',
            'password' => 'rootpass',
            'port' => 3306
        ]
    ],
    'route' => [
        '/^\/$/i' => [
            'type' => 'GET',
            'action' => 'homeAction'
        ],
        '/^\/list.+$/i' => [
            'type' => 'GET',
            'action' => 'listAction'
        ],
        '/^\/new$/i' => [
            'type' => 'GET',
            'action' => 'newAction'
        ],
        '/^\/edit\?id=\d+$/i' => [
            'type' => 'GET',
            'action' => 'editAction'
        ],
        '/^\/update$/i' => [
            'type' => 'POST',
            'action' => 'updateAction'
        ],
        '/^\/delete$/i' => [
            'type' => 'POST',
            'action' => 'deleteAction'
        ]
        ,
        '/^\/create$/i' => [
            'type' => 'POST',
            'action' => 'createAction'
        ]
    ],
    /**
     * @todo set auto_reload = false
     */
    'twig' => [
        'cache' => __DIR__ . '/tmp',
        'auto_reload' => true
    ],
    'memcache' => [
        'host' => 'localhost',
        'port' => 11211
    ]

];