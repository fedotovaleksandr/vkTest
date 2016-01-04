<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 03.01.2016
 * Time: 12:08
 */
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../lib/Twig/Autoloader.php';
/**
 * @return Twig_Environment
 */
function getTwig()  {
    global $config;
    $params= $config['twig'];
    Twig_Autoloader::register();
    $loader = new Twig_Loader_Filesystem(__DIR__ . '/../Resources/Twig');
    $twig = new Twig_Environment($loader, array(
        'cache' => $params['cache'],
        'auto_reload' => $params['auto_reload']
    ));
    $twig->addGlobal('session',$_SESSION);
    return $twig;
};
