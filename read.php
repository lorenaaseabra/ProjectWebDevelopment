<?php
session_start();

ini_set('default_charset', 'UTF-8');

if( $_SESSION['login'] == TRUE){

include ("databaseConnection.php");

$nome = $_SESSION['nome'];

$query = "SELECT * FROM contatos WHERE nome = '$nome'";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc ($result)) { 
  if($row["ismanager"] == true) {

if(isset ($_POST['pesquisa'])) {
	$query = "SELECT * FROM contatos WHERE nome LIKE '%$_POST[pesquisa]%' OR email LIKE '%$_POST[pesquisa]%'";
	$result = mysqli_query ($conn, $query);	
}else{
	$query = "SELECT * FROM contatos";
	$result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="read2.css" rel="stylesheet">
    <link href="style2.css" rel="stylesheet">

    <title>List</title>
  </head>

  <body>
    <header>
      <nav>
        <div>
          <ul>
              <a href="profile.php">Profile</a>
              <a href="read.php">List data</a>
              <a href="createNew.php">Create new</a>
              <a href="closeSession.php">End session</a>
          </ul>

        </div>
      </nav>
    </header>
    <main>

        <div> 
            <p><?PHP echo mysqli_num_rows ($result)?> register(s) found.</p>
        </div>

        <div>
          <table class="table">
            <tr>
              <td width="80" scope="col"><strong>Member Number</strong></td>
              <td scope="col"><strong>Name</strong></td>
              <td scope="col"><strong>Email</strong></td>
              <td scope="col"><strong>Birthdate</strong></td>
              <td scope="col" width="80"><strong>Update</strong></td>
              <td scope="col" width="80"><strong>Delete</strong></td>
            </tr>
            <?php while ($row = mysqli_fetch_assoc ($result)) { ?>
            <tr>
              <td scope="row"><?PHP echo $row ["memberNumber"]?></td>
              <td scope="row"><?PHP echo $row ["nome"]?></td>
              <td scope="row"><?PHP echo $row ["email"]?></td>
              <td scope="row"><?PHP echo $row ["birthdate"]?></td>
              <td scope="row"><a href="update.php?memberNumber=<?PHP echo $row ["memberNumber"]?>">Update</a></td>
              <td scope="row"><a href="delete.php?memberNumber=<?PHP echo $row ["memberNumber"]?>">Delete</a></td>
            </tr>
            <?php } ?>
        </table>

      </div>
      </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>
<?php
} 
else {
  ?>
  <p>Attention: This page is only for managers</p>
  <?php
}
}
// close connection
mysqli_close ($conn);

} else {
  header ('Location: loginAuthentication.php');
} 
?>
    