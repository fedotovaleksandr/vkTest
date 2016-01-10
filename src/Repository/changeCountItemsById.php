<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 06.01.2016
 * Time: 0:23
 */
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . "/../Database/db_mysqli_close.php";
require_once __DIR__ . "/../Database/db_mysqli_connect.php";

function changeCountItemsById($id,$val) {
    $config = getConfig();
    $params = $config['memcache'];

    $table = [
        'name' => 'item',
        'dbname' => 'db_vktest',
        'as' => 'i'
    ];
    $mysqli = db_mysqli_connect($table['dbname']);
    $queryUpdate = 'UPDATE store SET countitems = countitems + '. intval($val) .' WHERE idstore = '. intval($id);
    $resultUpdate = mysqli_query($mysqli, $queryUpdate);
    db_mysqli_close($mysqli);

    $memcache = memcache_connect($params['host'], $params['port']);
    memcache_flush($memcache);
    memcache_close($memcache);
}