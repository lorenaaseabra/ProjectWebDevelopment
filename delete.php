<?php
session_start();

ini_set('default_charset', 'UTF-8');

if( $_SESSION['login'] == TRUE){

    // database connection
    include ("datebaseConnect.php");
    $query = "DELETE FROM contatos WHERE codigo=$_GET[codigo]";
    mysqli_query ($conn, $query);
    mysqli_close ($conn);
    // redirect to page list
    header("location: list.php");
    
} else {
    header ('Location: delete.php');
  } 
?>