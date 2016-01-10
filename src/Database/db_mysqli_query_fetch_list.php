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
    $config = getConfig();
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

        //another proc
       /* $pid = pcntl_fork();
        if ($pid == 0) {*/
            memcache_set($memcache, $memcacheQueryKey, $data, 0, 60 * 10);
        /*    posix_kill(posix_getpid(), SIGTERM);
        }*/
    }
    memcache_close($memcache);
    return $data;
}