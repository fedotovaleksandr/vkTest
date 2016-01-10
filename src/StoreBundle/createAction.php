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
require_once __DIR__ . "/../Database/db_mysqli_close.php";
require_once __DIR__ . "/../Database/db_mysqli_connect.php";
require_once __DIR__ . "/../Repository/changeCountItemsById.php";

function createAction()
{
    $config = getConfig();
    $params = $config['memcache'];

    $table = [
        'name' => 'item',
        'dbname' => 'db_vktest',
        'as' => 'i'
    ];
    $item = handleRequest($_POST);

    $mysqli = db_mysqli_connect($table['dbname']);

    $queryInsert = "INSERT INTO item (name,description,price,url) VALUES ("
        . "'" . mysqli_real_escape_string($mysqli, $item['name']) . "',"
        . "'" . mysqli_real_escape_string($mysqli, $item['description']) . "',"
        . $item['price'] . ","
        . "'" . mysqli_real_escape_string($mysqli, $item['url']) . "'"
        . ")";
    $resultInsert = mysqli_query($mysqli, $queryInsert);
    $resultError = mysqli_error($mysqli);
    db_mysqli_close($mysqli);

    if (!$resultInsert) {
        addAlert('danger', 'Произошла ошибка записи:' . $resultError);
        $url = 'http://' . $_SERVER['HTTP_HOST'] . "/";
        header('Location: ' . $url);
        exit();
    };


    //another proc
    $pid = pcntl_fork();
    if ($pid == 0) {
        changeCountItemsById(1, 1);
        exit(0);
    }
    addAlert('success', 'Продукт добавлен');
    $url = 'http://' . $_SERVER['HTTP_HOST'] . "/";
    header('Location: ' . $url);
}