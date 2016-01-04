<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 04.01.2016
 * Time: 23:13
 */
require_once __DIR__ . '/../../config.php';

function db_mysqli_query_fetch($mysqli,$query,$MYSQLI_TYPE){
    global $config;
    $params=$config['memcache'];
    $memcache=memcache_connect($params['host'],$params['port']);
    $memcacheQueryKey='QUERY'. md5($query);
    $idsArray=memcache_get($memcache, $memcacheQueryKey);
    if (!empty($idsArray)){

    }else{

    }


    memcache_set($memcache, 'var_key', 'some variable', 0, 60);
    echo memcache_get($memcache, 'var_key');
    memcache_close($memcache);
    exit();
}