<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 05.01.2016
 * Time: 21:49
 */
require_once __DIR__ . "/buildListItemQueryTypes.php";
function buildListItemQuery($queryAssoc, $countItems)
{
    /**
     * build slow query
     */
    $table = $queryAssoc['table'];
    $slowQuery = 'SELECT ';
    $slowQuery = $slowQuery . implode(",", $queryAssoc['query']['select']);
    $slowQuery = $slowQuery . ' FROM ' . $table['name'];
    $orderColumn = $queryAssoc['query']['order']['column'];
    $orderDir = $queryAssoc['query']['order']['dir'];
    $slowQuery = $slowQuery . ' ORDER BY ' . $orderColumn . ' ' . $orderDir;
    /**
     * important $slowQueryKey
     */
    $slowQueryType = md5($slowQuery);
    $start = $queryAssoc['query']['start'];
    $length = $queryAssoc['query']['length'];
    $slowQuery = $slowQuery . ' LIMIT ' . $start . ',' . $length;
    $list = $_SESSION['list'];
    $fastQuery = null;
    $itemsLast = $countItems % $length;
    $lastPage = $countItems - $itemsLast;

    /**
     * build fast query
     */
    $queryParam = [
        'list' => $list,
        'start' => $start,
        'orderColumn' => $orderColumn,
        'queryAssoc' => $queryAssoc,
        'table' => $table,
        'lastPage' => $lastPage,
        'itemsLast' => $itemsLast,
        'length' => $length,
        'slowQueryType' => $slowQueryType,
        'orderDir' => $orderDir

    ];
    if ($orderColumn != 'iditem')
        $fastQuery = buildQueryforAnotherField($queryParam);
    else
        $fastQuery = buildQueryforIdField($queryParam);


    return [
        'slow' => $slowQuery,
        'fast' => $fastQuery,
        'slowQueryType' => $slowQueryType,
    ];

}
