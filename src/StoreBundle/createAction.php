<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 03.01.2016
 * Time: 19:39
 */
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . "/../Common/handleRequest.php";
require_once __DIR__ . "/../Common/addAlert.php";
function createAction()
{
    global $config;

    $table = [
        'name' => 'item',
        'dbname' => 'db_vktest',
        'as' => 'i'
    ];
    $item = handleRequest($_POST);


    $dbParam = $config['databases'][$table['dbname']];
    $mysqli = mysqli_connect($dbParam['host'], $dbParam['user'], $dbParam['password'], $table['dbname'], $dbParam['port']);
    if (mysqli_connect_errno()) {
        addAlert('danger','Нет подключения к базе данных:'. mysqli_connect_error());
        $url = 'http://' . $_SERVER['HTTP_HOST'] . "/";
        header('Location: ' . $url);
        exit();
    };
    $queryInsert = "INSERT INTO item (name,description,price,url) VALUES ("
        . "'" . mysqli_real_escape_string($mysqli, $item['name']) . "',"
        . "'" . mysqli_real_escape_string($mysqli, $item['description']) . "',"
        . $item['price'] . ","
        . "'" . mysqli_real_escape_string($mysqli, $item['url']) . "'"
        . ")";

    $queryUpdate = "UPDATE store SET countitems = countitems + 1 WHERE idstore = 1";

    $resultInsert = mysqli_query($mysqli, $queryInsert);
    $resultUpdate = mysqli_query($mysqli, $queryUpdate);


    if (!$resultInsert || !$resultUpdate) {
        addAlert('danger','Произошла ошибка записи:'. mysqli_error($mysqli));
        $url = 'http://' . $_SERVER['HTTP_HOST'] . "/";
        header('Location: ' . $url);
        exit();
    };

    mysqli_close($mysqli);
    addAlert('success','Продукт добавлен');
    $url = 'http://' . $_SERVER['HTTP_HOST'] . "/";
    header('Location: ' . $url);
}