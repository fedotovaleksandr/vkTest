<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 02.01.2016
 * Time: 22:51
 */

require_once __DIR__ . "/../Common/twigTune.php";

function homeAction()
{
    global $getTwig;
    $twig = $getTwig();
    echo $twig->render('/View/home.html.twig', []);

}