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
    global $config;
    $params = $config['memcache'];

    $_return = true;
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

    $memcache = memcache_connect($params['host'], $params['port']);
    memcache_delete($memcache,['list','countitems']);
    memcache_close($memcache);


    if ($deleteRows = mysqli_affected_rows($mysqli)<= 0 ){
        $_return=false;
    }else
    {
        $resultUpdate = mysqli_query($mysqli, 'UPDATE store SET countitems = countitems -'. $deleteRows .' WHERE idstore = 1');
    }
    db_mysqli_close($mysqli);

    return $_return;
}