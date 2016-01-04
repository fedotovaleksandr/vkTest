<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 04.01.2016
 * Time: 20:42
 */
require_once __DIR__ . '/../../config.php';
function db_mysqli_connect($db_name)
{
    global $config;
    $dbParam = $config['databases'][$db_name];
    $mysqli = mysqli_connect($dbParam['host'], $dbParam['user'], $dbParam['password'], $db_name, $dbParam['port']);
    if (mysqli_connect_errno()) {
        addAlert('danger','Нет подключения к базе данных:'. mysqli_connect_error());
        $url = 'http://' . $_SERVER['HTTP_HOST'] . "/";
        header('Location: ' . $url);
        exit();
    };
    return $mysqli;
}