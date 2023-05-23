<?php
session_start();

ini_set('default_charset', 'UTF-8');

include ("databaseConnect.php");

$nameErr = $emailErr = $passwordErr= "";
$name = $email = $password = $hidden = $disabled = "";


function test_input($dados) {
	$dados = trim($dados);
	$dados = stripslashes($dados);
	$dados = htmlspecialchars($dados);
	return $dados;
  }

if( !empty( $_SESSION['login'] )){
    header ('Location: index.php');
} else {

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (empty($_POST["email"])) {
      $emailErr = "Email is required!";
    } else {
      $email = test_input($_POST["email"]);
      // check if e-mail address is well-formed
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
      }
    }

    if (empty($_POST["password"])) {
      $nameErr = "Password is required!";
    } else {
      $name = test_input($_POST["password"]);
    }
    
    if ($passwordErr =="" AND $emailErr == ""){
      $query = "SELECT * FROM contatos WHERE email='$_POST[email]' AND  password='$_POST[password]'";
      $result = mysqli_query ($conn,$query);
      $row = mysqli_fetch_assoc ($result);
      if (mysqli_num_rows($result) > 0){
        $_SESSION['name'] = $row['name'];
        $_SESSION['login'] = TRUE;
        header ('Location: index.php');
      } else {
        $autErr ="Please verify you authentication data!";
      }
  
    }
  }
}


?>

<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=ISO8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- general css -->
    <link rel="stylesheet" href="./css/style.css">

    <!-- own css -->
    <link rel="stylesheet" href="./css/registration.css">

    <title>Login Page</title> 
  </head>

  <body>
    <main>

      <!-- info -->
      <?php
        if($_SERVER["REQUEST_METHOD"] == "POST" AND ($passwordErr !="" OR $emailErr != "" OR $autErr !="")) {
      ?>
      <div>
        <h4>Alert!</h4>
        <hr>
        <?php
          echo $autErr;
          echo $emailErr;
          echo $passwordErr;
        ?>
      </div>
      <?php } ?><!-- /.info -->

      <div class="container">
        <div>
            <h2>Login</h2>
        </div>
        <div>
            <form name="frmLogin" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="input-item">
                    <label for="email">Email: </label><br>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" required autofocus>
                </div>
                <br>
                <div class="input-item">
                    <label for="password">Password: </label><br>
                    <input type="password" id="password" name="password" required>
                </div>
                <br>
                <div>
                    <input id="btn-submit" type="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
    <a href="profile.html">Clicar aqui para testar a prox página</a>
    </main>

  </body>
</html>
<?php
  mysqli_close($conn);
?>