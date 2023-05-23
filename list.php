<?php
session_start();
ini_set('default_charset', 'UTF-8');

if( $_SESSION['login'] == TRUE){

// database connection
  include ("databaseConnect.php");

  if(isset ($_POST['pesquisa'])) {
    $query = "SELECT * FROM contatos WHERE name LIKE '%$_POST[pesquisa]%' OR email LIKE '%$_POST[pesquisa]%'";
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
      <meta name="description" content="">
      <meta name="author" content="">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
      <!-- insert here the reference to stylesheet file -->
      <link rel="stylesheet" href="./css/style.css">
      <title>User List</title>
    </head>

    <body>
      <main>

          <div> <!-- info -->
              <p><?PHP echo mysqli_num_rows ($result)?> register(s) found.</p>
          </div>

          <div class="container">
            <table>
              <tr> 
                <td width="80"><strong>Member number</strong></td>
                <td><strong>NAME</strong></td>
                <td><strong>EMAIL</strong></td>
                <td><strong>Birthdate</strong></td>
                <td width="80"><strong>UPDATE</strong></td>
                <td width="80"><strong>DELETE</strong></td>
              </tr>
              <?php while ($row = mysqli_fetch_assoc ($result)) { ?>
              <tr>
                <td><?PHP echo $row ["memberNumber"]?></td>
                <td><?PHP echo $row ["name"]?></td>
                <td><?PHP echo $row ["email"]?></td>
                <td><?PHP echo $row ["birthdate"]?></td>
                <td><a href="update.php?memberNumber=<?PHP echo $row ["memberNumber"]?>">UPDATE</a></td>
                <td><a href="delete.php?memberNumber=<?PHP echo $row ["memberNumber"]?>">DELETE</a></td>
              </tr>
              <?php } ?>
            </table>

        </div><!-- /.list -->

        <a href="delete.php">Clicar aqui para testar a prox página</a>
      </main>
  </body>
  </html>
  <?php
  // close connection
  mysqli_close ($conn);
}else{
  header ('Location: list.php');
} 
?>