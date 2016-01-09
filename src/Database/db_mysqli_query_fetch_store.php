<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 05.01.2016
 * Time: 23:00
 */
require_once __DIR__ . '/../../config.php';

function db_mysqli_query_fetch_store($mysqli, $query, $MYSQLI_TYPE)
{
    global $config;
    $params = $config['memcache'];
    $memcache = memcache_connect($params['host'], $params['port']);

    $memcacheQueryKey = 'QUERY' . md5($query);
    $data = memcache_get($memcache, $memcacheQueryKey);
    if (!empty($data)) {

    } else {
        $result = mysqli_query($mysqli, $query);
        $data = [];
        while ($row = mysqli_fetch_array($result, $MYSQLI_TYPE)) {
            $data[] = $row;
        }
        memcache_set($memcache,$memcacheQueryKey,$data,0,60*10);

    }
    memcache_close($memcache);
    return $data;
}