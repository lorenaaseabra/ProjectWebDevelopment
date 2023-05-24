<?php
//initialize session
session_start();

// PHP charset
ini_set('default_charset', 'UTF-8');

if( $_SESSION['login'] == TRUE){
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- insert here the reference to stylesheet file -->
    <link href="" rel="stylesheet">
    <title>EXEMPLE TO MANAGE DATABASE WITH PHP</title>
  </head>

  <body>
  <header>
      <!-- navigation bar -->
      <nav>
        <a href="#">CRUD</a>
        <div>
          <ul>
            <li>
              <a href="index.php">Home</a>
            </li>
            <li>
              <a href="read.php">List data</a>
            </li>
            <li >
              <a href="register.php">Create new</a>
            </li>
            <li>
              <a href="closeSession.php">End session</a>
            </li>
          </ul>

          <!-- search form -->
          <form name="frmPesquisa" method="post" action="read.php">
            <input type="text" placeholder="Search" aria-label="Search" name="pesquisa">
            <button type="submit">Search</button>
          </form>

        </div>
      </nav>
      <!-- /.navigation bar -->
    </header>

    <main>     

    </main>

</body>
</html>
<?php 
} else {
  header ('Location: loginAuthentication.php');
} 
?>