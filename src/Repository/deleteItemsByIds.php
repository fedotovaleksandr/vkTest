<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 04.01.2016
 * Time: 21:24
 */
require_once __DIR__ . "/../Database/db_mysqli_close.php";
require_once __DIR__ . "/../Database/db_mysqli_connect.php";
require_once __DIR__ . '/../../config.php';
function deleteItemsByIds($ids){



    $table = [
        'name' => 'item',
        'dbname' => 'db_vktest',
        'as' => 'i'
    ];
    $mysqli=db_mysqli_connect($table['dbname']);

    $sqlQuery = "DELETE FROM item WHERE iditem IN (" . implode(',',$ids) .')';

    $result = mysqli_query($mysqli, $sqlQuery);



    $_return = $result;
    if (($deleteRows = mysqli_affected_rows($mysqli))<= 0 ){
        $_return=false;
    }
    var_dump($_return);
    var_dump($sqlQuery);
    var_dump($deleteRows);

    db_mysqli_close($mysqli);

    if ($_return)
    {
        $pid = pcntl_fork();
        if ($pid == 0) {
            changeCountItemsById(1,$deleteRows*-1);
            exit();
        }

    }


    return $_return;
}