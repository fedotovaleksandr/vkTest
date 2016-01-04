<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 03.01.2016
 * Time: 23:45
 */
require_once __DIR__ . "/../Database/db_mysqli_close.php";
require_once __DIR__ . "/../Database/db_mysqli_connect.php";
function getItemsByIds($ids){

    $table = [
        'name' => 'item',
        'dbname' => 'db_vktest',
        'as' => 'i'
    ];
    $sqlQuery = "SELECT * FROM item WHERE iditem IN (" . implode(',',$ids) .')';

    $mysqli=db_mysqli_connect($table['dbname']);

    $result = mysqli_query($mysqli, $sqlQuery);
    $rows = [];
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $rows[] = $row;
    }
    db_mysqli_close($mysqli);
    return $rows;
}