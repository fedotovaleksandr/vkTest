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
function listAction()
{
    global $config;

    $table = [
        'name' => 'item',
        'dbname' => 'db_vktest',
        'as' => 'i'
    ];
    $sqlQuery = 'SELECT ';
    $columnsName = [];
    foreach ($_GET['columns'] as $column) {
        if (!empty($column['data'])) {
            $columnsName[] = $table['as'] . '.' . $column['data'];
        }
    };
    $sqlQuery = $sqlQuery . implode(",", $columnsName) . ' ';
    $sqlQuery = $sqlQuery . 'FROM ' . $table['name'] . ' as ' . $table['as'];
    $order = $_GET['order'][0];
    $orderColumn = $order['column'];
    $sqlQuery = $sqlQuery . ' ORDER BY ' . $columnsName[$orderColumn] . ' ' . $order['dir'];
    /**
     * @todo edit limit
     */
    $start=intval($_GET['start']);
    $end=$start+intval($_GET['length']);
    $sqlQuery = $sqlQuery . ' LIMIT ' . $start . ',' . $_GET['length'];

    $mysqli =db_mysqli_connect($table['dbname']);

    $result = mysqli_query($mysqli, $sqlQuery);

    $resultStore = mysqli_query($mysqli, 'SELECT s.countitems FROM store AS s WHERE s.idstore = 1');
    $rowTotal=mysqli_fetch_array($resultStore, MYSQLI_ASSOC);

    $rows = [];
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $rows[] = $row;
    }

    $response= [
        'recordsTotal'=>$rowTotal['countitems'],
        'recordsFiltered'=>$rowTotal['countitems'],
        'data'=>$rows,
        'draw'=>$_GET['draw'],
        'start'=>$_GET['start']
    ];
    db_mysqli_close($mysqli);
    echo json_encode($response);
}