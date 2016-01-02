<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 02.01.2016
 * Time: 22:48
 */

$router = function () use ($config)
{
    $uri = $_SERVER['REQUEST_URI'];
    $routers = $config['route'];
    $action = null;
    var_dump($uri);

    foreach ($routers as $key => $value) {


        if (preg_match($key, $uri)) {
            $action = $value['action'];
            $action();
        }


    }
    if (empty($action)) {
        echo 'not found';
    }
};