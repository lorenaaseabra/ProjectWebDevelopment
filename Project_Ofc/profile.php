<?php
//initialize session
session_start();

// PHP charset
ini_set('default_charset', 'UTF-8');

if($_SESSION['login'] == TRUE){

include ("databaseConnection.php");

$nome = $_SESSION['nome'];

$query = "SELECT * FROM contatos WHERE nome = '$nome'";
$result = mysqli_query($conn, $query);

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
      <nav>
        <div>
        <ul>
              <a href="profile.php">Home</a>
              <a href="read.php">List data</a>
              <a href="register.php">Create new</a>
              <a href="closeSession.php">End session</a>
          </ul>

          <form name="frmPesquisa" method="post" action="read.php">
            <input type="text" placeholder="Search" aria-label="Search" name="pesquisa">
            <button type="submit">Search</button>
          </form>

        </div>
      </nav>
    </header>

    <main>     
      <h1>Profile</h1>
    <?php while ($row = mysqli_fetch_assoc ($result)) { ?>
      <p><b>Name: </b><?PHP echo $row ["nome"]?></p>
      <p><b>Email: </b><?PHP echo $row ["email"]?></p>
      <p><b>Member number: </b><?PHP echo $row ["memberNumber"]?></p>
      <p><b>Password: </b><?PHP echo $row ["password"]?></p>
    <?php } ?>
    </main>

</body>
</html>
<?php 
} else {
  header ('Location: loginAuthentication.php');
} 
?>