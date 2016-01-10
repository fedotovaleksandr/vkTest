<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 03.01.2016
 * Time: 14:15
 */
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . "/../Common/handleRequest.php";
require_once __DIR__ . "/../Common/addAlert.php";
require_once __DIR__ . "/../Database/db_mysqli_close.php";
require_once __DIR__ . "/../Database/db_mysqli_connect.php";
function updateAction()
{
    $config = getConfig();

    $table = [
        'name' => 'item',
        'dbname' => 'db_vktest',
        'as' => 'i'
    ];
    $item = handleRequest($_POST);

    $mysqli = db_mysqli_connect($table['dbname']);

    $queryUpdate = "UPDATE item SET "
        . "name='" . mysqli_real_escape_string($mysqli, $item['name']) . "',"
        . "description='" . mysqli_real_escape_string($mysqli, $item['description']) . "',"
        . "price=". $item['price'] . ","
        . "url='" . mysqli_real_escape_string($mysqli, $item['url']) . "'"
        . " WHERE iditem=" . $item['iditem'];

    $resultUpdate = mysqli_query($mysqli, $queryUpdate);
    $resultError = mysqli_error($mysqli);
    db_mysqli_close($mysqli);

    if (!$resultUpdate) {
        addAlert('danger','Произошла ошибка записи:'. $resultError);
        $url = 'http://' . $_SERVER['HTTP_HOST'] . "/";
        header('Location: ' . $url);
        exit();
    };


    addAlert('success','Продукт сохранен!');
    $url = 'http://' . $_SERVER['HTTP_HOST'] . "/";
    header('Location: ' . $url);


}