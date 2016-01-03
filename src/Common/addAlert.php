<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 03.01.2016
 * Time: 22:45
 */
/**
 * @param $alertType "'info','success','warning','danger'"
 * @param $message "message for alert"
 */
function addAlert($alertType,$message)
{
    if (!isset($_SESSION['flashbag']))
        $_SESSION['flashbag']=[];
    if (!isset($_SESSION['clear']))
        $_SESSION['clear']=0;


    $flashBag=$_SESSION['flashbag'];
    $flashBag[]=['alertType'=>$alertType,'message'=>$message];
    $_SESSION['flashbag']=$flashBag;
}