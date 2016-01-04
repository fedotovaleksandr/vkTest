<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 04.01.2016
 * Time: 21:24
 */
require_once __DIR__ . "/../Database/db_mysqli_close.php";
require_once __DIR__ . "/../Database/db_mysqli_connect.php";
function deleteItemsByIds($ids){

    $table = [
        'name' => 'item',
        'dbname' => 'db_vktest',
        'as' => 'i'
    ];
    $mysqli=db_mysqli_connect($table['dbname']);

    $sqlQuery = "DELETE FROM item WHERE iditem IN (" . implode(',',$ids) .')';

    $result = mysqli_query($mysqli, $sqlQuery);

    $rows = [];
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $rows[] = $row;
    }
    if (mysqli_affected_rows($mysqli)<= 0 ){
        return false;
    }
    db_mysqli_close($mysqli);

    return true;
}