<?php
//initialize session
session_start();

// PHP charset
ini_set('default_charset', 'UTF-8');

if( $_SESSION['login'] == TRUE){

    include ("databaseConnection.php");
    $query = "DELETE FROM contatos WHERE memberNumber=$_GET[memberNumber]";
    mysqli_query ($conn, $query);
    mysqli_close ($conn);
    header("location: read.php");
    
} else {
    header ('Location: loginAuthentication.php');
  } 
?>