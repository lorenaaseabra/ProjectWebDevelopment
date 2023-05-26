<?php
session_start();

ini_set('default_charset', 'UTF-8');

if( $_SESSION['login'] == TRUE){
    session_unset();
    session_destroy();
}

header ('Location: loginAuthentication.php');
?>