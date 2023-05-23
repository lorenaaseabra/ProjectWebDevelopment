<?php
//initialize session
session_start();

// PHP charset
ini_set('default_charset', 'UTF-8');

if( $_SESSION['login'] == TRUE){
    session_unset();
    session_destroy();
}

header ('Location: login.php');
?>