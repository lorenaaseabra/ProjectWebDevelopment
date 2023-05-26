<?php
session_start();

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="read2.css" rel="stylesheet">
    <link href="style2.css" rel="stylesheet">

    <title>User Profile</title>
  </head>

  <body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div>
          <ul class="navbar-nav">
            <li class="nav-item active"><a href="profile.php">Profile</a></li>
            <li class="nav-item active"><a href="read.php">List data</a></li>
            <li class="nav-item active"><a href="createNew.php">Create new</a></li>
            <li class="nav-item active"><a href="closeSession.php">End session</a></li>
          </ul>
        </div>
      </nav>
    </header>

    <main> 
      <div>    
        <?php while ($row = mysqli_fetch_assoc ($result)) { ?>
          <p><b>Name: </b><?PHP echo $row ["nome"]?></p>
          <p><b>Email: </b><?PHP echo $row ["email"]?></p>
          <p><b>Member number: </b><?PHP echo $row ["memberNumber"]?></p>
          <p><b>Password: </b><?PHP echo $row ["password"]?></p>
          <p><b>Birthdate: </b><?PHP echo $row ["birthdate"]?></p>
          <?php 
          if($row["ismanager"] == true) {
          ?>
          <p>You are a <b>manager</b></p>
          <?php } else { ?>
            <p>Attention: the 'list' and 'add new' pages are only acessible for managers. 
              <br>Your plan only allows the other pages. Contact us for an upgrade!</p>
          <?php } ?>
          <button class="btn-primary"><a href="update.php?memberNumber=<?PHP echo $row ["memberNumber"]?>">Update</a></button>
        <?php } ?>
      </div>
    </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
<?php 
} else {
  header ('Location: loginAuthentication.php');
} 
?>