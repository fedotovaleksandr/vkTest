<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 03.01.2016
 * Time: 14:13
 */
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . "/../Database/db_mysqli_close.php";
require_once __DIR__ . "/../Database/db_mysqli_connect.php";
require_once __DIR__ . "/../Database/db_mysqli_query_fetch_list.php";
require_once __DIR__ . "/../Database/db_mysqli_query_fetch_store.php";
require_once __DIR__ . "/../Common/buildListItemQuery.php";

function listAction()
{
    global $config;

    $columnsName = [];
    foreach ($_GET['columns'] as $column) {
        if (!empty($column['data'])) {
            $columnsName[] = $column['data'];
        }
    };
    $order = $_GET['order'][0];
    $orderColumn = $order['column'];
    $start = intval($_GET['start']);

    $sqlAssoc = [
        'table' => [
            'name' => 'item',
            'dbname' => 'db_vktest',
            'as' => 'i'
        ],
        'query' => [
            'select' => $columnsName,
            'from' => 'item',
            'order' => [
                'column' => $columnsName[$orderColumn],
                'dir' => $order['dir']
            ],
            'start' => $start,
            'length' => $_GET['length']
        ]

    ];

    $mysqli = db_mysqli_connect($sqlAssoc['table']['dbname']);
    $rowTotal = db_mysqli_query_fetch_store($mysqli, 'SELECT s.countitems FROM store AS s WHERE s.idstore = 1', MYSQLI_ASSOC)[0];
    $sqlQueryes = buildListItemQuery($sqlAssoc, $rowTotal['countitems']);
    $rows = db_mysqli_query_fetch_list($mysqli, $sqlQueryes, MYSQLI_ASSOC);
    db_mysqli_close($mysqli);

//    var_dump($_SESSION);
//    var_dump($sqlQueryes);

    $_SESSION['list'] = [
        'lastitem' => $rows[count($rows) - 1],
        'firstitem' => $rows[0],
        'lastpage' => $start,
        'slowQueryType'=>$sqlQueryes['slowQueryType']
    ];


    $response = [
        'recordsTotal' => $rowTotal['countitems'],
        'recordsFiltered' => $rowTotal['countitems'],
        'data' => $rows,
        'draw' => $_GET['draw'],
        'start' => $_GET['start']
    ];

    echo json_encode($response);
}