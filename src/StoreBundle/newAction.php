<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 03.01.2016
 * Time: 14:56
 */
require_once __DIR__ . "/../Common/twigTune.php";

function newAction()
{
    $twig = getTwig();
    echo $twig->render('/View/new.html.twig', [
        'action' => '/create'
    ]);
}