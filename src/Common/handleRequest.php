<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 03.01.2016
 * Time: 21:00
 */
/**
 * @param $request "POST from datatable"
 * @return array "item"
 */
function handleRequest($request)
{
    $item = [
        'iditem' => $request['iditem'],
        'name' => $request['name'],
        'description' => $request['description'],
        'price' => floatval($request['price']),
        'url' => $request['url'],

        ];
    return $item;
}