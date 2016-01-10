<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 08.01.2016
 * Time: 13:46
 */
require_once __DIR__ . "/../Database/db_mysqli_close.php";
require_once __DIR__ . "/../Database/db_mysqli_connect.php";
require_once __DIR__ . "/../Database/db_mysqli_query_fetch_list.php";
require_once __DIR__ . "/../Common/buildListItemQuery.php";
require_once __DIR__ . '/../../config.php';

function afterLictAction($queryAssoc, $rowStore)
{
    $config = getConfig();
    /**
     * Count of items page,that need be cached,because
     * but last-1/-2/-3/-4 use slow query
     */
    $COUNT_BEFORE_END = 5;

    $length = $queryAssoc['query']['length'];
    $itemsLast = $rowStore['countitems'] % $length;
    $lastPage = $rowStore['countitems'] - $itemsLast;
    $start = $queryAssoc['query']['start'];
    /**
     * only for last page
     */
    if ($start == $lastPage) {
        //last 5 page in cache&
        $queryCheckPre = array_merge($queryAssoc, []);
        $queryCheckPre['query']['start'] = $start - 1 * $length;
        $queryPre = buildListItemQuery($queryCheckPre, $rowStore['countitems']);
        $params = $config['memcache'];
        $memcache = memcache_connect($params['host'], $params['port']);
        $memcacheQueryKey = 'QUERY' . $queryPre['slow'];
        $data = memcache_get($memcache, $memcacheQueryKey);
        memcache_close($memcache);


        //another proc
        if (empty($data)) {
            $pid = pcntl_fork();
            if ($pid == 0) {
                $mysqli = db_mysqli_connect($queryAssoc['table']['dbname']);

                for ($i = 1; $i < $COUNT_BEFORE_END; $i++) {
                    $queryAssoc['query']['start'] = $start - $i * $length;
                    $sqlQueryes = buildListItemQuery($queryAssoc, $rowStore['countitems']);
                    $rows = db_mysqli_query_fetch_list($mysqli, $sqlQueryes, MYSQLI_ASSOC);

                    $_SESSION['list'] = [
                        'lastitem' => $rows[count($rows) - 1],
                        'firstitem' => $rows[0],
                        'lastpage' => $queryAssoc['query']['start'],
                        'slowQueryType'=>$sqlQueryes['slowQueryType']
                    ];
                    //
                    usleep(500);
                }

                db_mysqli_close($mysqli);

                exit(0);
                //end new proc
            }
        }
    }
}

;