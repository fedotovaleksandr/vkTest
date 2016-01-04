<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 03.01.2016
 * Time: 14:14
 */


require_once __DIR__ . "/../Repository/deleteItemsByIds.php";
function deleteAction(){
    $table = [
        'name' => 'item',
        'dbname' => 'db_vktest',
        'as' => 'i'
    ];
    $itemIds = $_POST['ids'];

    $succes=deleteItemsByIds($itemIds);

    $response = ['success' => $succes];
    echo json_encode($response);


}