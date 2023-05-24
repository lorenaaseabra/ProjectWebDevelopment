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
    <link href="read.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <title>Profile</title>
  </head>

  <body>
  <header>
      <!-- navigation bar -->
      <nav>
        <div>
        <ul>
              <a href="profilw.php">Home</a>
              <a href="read.php">List data</a>
              <a href="register.php">Create new</a>
              <a href="closeSession.php">End session</a>
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