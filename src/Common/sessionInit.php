<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 03.01.2016
 * Time: 23:04
 */
function sessionInit(){
    session_start();

    if (isset($_SESSION['clear'])) {
        if ($_SESSION['clear'] > 0) {
            session_unset();
        }
        else {
            $_SESSION['clear']++;
        }
    }

}