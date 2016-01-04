<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 03.01.2016
 * Time: 23:20
 */
require_once __DIR__ . "/../Repository/getItemsByIds.php";

function editAction()
{

    $twig = getTwig();
    $item = getItemsByIds([$_GET['id']])[0];
    echo $twig->render('/View/edit.html.twig', [
        'action' => '/update',
        'item'=> $item
    ]);
}