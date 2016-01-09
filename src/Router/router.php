<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 02.01.2016
 * Time: 22:48
 */
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . "/../StoreBundle/actionProvider.php";
require_once __DIR__ . "/../Common/twigTune.php";

function router()  {
    global $config;

    $uri = $_SERVER['REQUEST_URI'];
    $type = $_SERVER['REQUEST_METHOD'];
    $routers = $config['route'];
    $action = null;
    foreach ($routers as $key => $value) {
        if (preg_match($key, $uri)) {
            if ($type === $value['type']) {
                $action = $value['action'];
                $action();
                break;
            }
        }
    }
    if (empty($action)) {
        $twig = getTwig();
        echo $twig->render('/View/404.html.twig', [
            'uri' => $uri
        ]);
    }
};