<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 04.01.2016
 * Time: 23:13
 */
require_once __DIR__ . '/../../config.php';

function db_mysqli_query_fetch_list($mysqli, $query, $MYSQLI_TYPE)
{
    global $config;
    $params = $config['memcache'];
    $memcache = memcache_connect($params['host'], $params['port']);

    $memcacheQueryKey = 'QUERY' . $query['slow'];
    $data = memcache_get($memcache, $memcacheQueryKey);
    if (!empty($data)) {

    } else {
        if (!empty($query['fast'])) {

            $result = mysqli_query($mysqli, $query['fast']);
        }else{
            $result = mysqli_query($mysqli, $query['slow']);
        }
        $data = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[] = $row;
        }

        memcache_set($memcache,$memcacheQueryKey,$data,0,60*10);
        $memcache->tag_add('list',$memcacheQueryKey);

    }
    memcache_close($memcache);
    return $data;
}