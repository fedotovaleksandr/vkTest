<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 03.01.2016
 * Time: 23:45
 */
require_once __DIR__ . '/../../config.php';
function getItemsByIds($ids){
    global $config;
    $table = [
        'name' => 'item',
        'dbname' => 'db_vktest',
        'as' => 'i'
    ];
    $sqlQuery = "SELECT * FROM item WHERE iditem IN (" . implode(',',$ids) .')';

    $dbParam = $config['databases'][$table['dbname']];
    $mysqli = mysqli_connect($dbParam['host'], $dbParam['user'], $dbParam['password'], $table['dbname'], $dbParam['port']);
    if (mysqli_connect_errno()) {
        addAlert('danger','Нет подключения к базе данных:'. mysqli_connect_error());
        $url = 'http://' . $_SERVER['HTTP_HOST'] . "/";
        header('Location: ' . $url);
        exit();
    };
    $result = mysqli_query($mysqli, $sqlQuery);
    $rows = [];
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $rows[] = $row;
    }
    return $rows;
}