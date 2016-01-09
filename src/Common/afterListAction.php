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

function afterLictAction($queryAssoc, $rowStore)
{
    /**
     * Count of items page,that need be cached,because
     * last-1= use fastquery
     * but last-2/-3/-4 use slow query
     */
    $COUNT_BEFORE_END = 5;

    $length = $queryAssoc['query']['length'];
    $countItems = $rowStore['countitems'];
    $itemsLast = $countItems % $length;
    $lastPage = $countItems - $itemsLast;
    $start = $queryAssoc['query']['start'];
    /**
     * only for last page
     */
    if ($start == $lastPage) {

        //another proc
        $pid = pcntl_fork();
        if ($pid == 0) {
            $mysqli = db_mysqli_connect($queryAssoc['table']['dbname']);

            for ($i = 2; $i < $COUNT_BEFORE_END; $i++) {
                $queryAssoc['query']['start'] = $start - $i * $length;
                $sqlQueryes = buildListItemQuery($queryAssoc, $rowStore['countitems']);
                db_mysqli_query_fetch_list($mysqli, $sqlQueryes, MYSQLI_ASSOC);

            }

            db_mysqli_close($mysqli);

            exit();
            //end new proc
        }
    }
}

;