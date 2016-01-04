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
function createAction()
{
    global $config;

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

    $queryUpdate = "UPDATE store SET countitems = countitems + 1 WHERE idstore = 1";

    $resultInsert = mysqli_query($mysqli, $queryInsert);
    $resultUpdate = mysqli_query($mysqli, $queryUpdate);


    if (!$resultInsert || !$resultUpdate) {
        addAlert('danger', 'Произошла ошибка записи:' . mysqli_error($mysqli));
        $url = 'http://' . $_SERVER['HTTP_HOST'] . "/";
        header('Location: ' . $url);
        exit();
    };

    db_mysqli_close($mysqli);
    addAlert('success', 'Продукт добавлен');
    $url = 'http://' . $_SERVER['HTTP_HOST'] . "/";
    header('Location: ' . $url);
}