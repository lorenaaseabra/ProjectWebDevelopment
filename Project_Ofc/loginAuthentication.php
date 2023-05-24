<?php
//initialize session
session_start();

// PHP charset
ini_set('default_charset', 'UTF-8');

// database connection
include ("databaseConnection.php");

// intialize variables
$nomeErr = $emailErr = $passwordErr= ""; //ADICIONAR BIRTH DATE!!!!
$nome = $email = $password = $hidden = $disabled = "";

// "cleaning data"
function test_input($dados) {
	$dados = trim($dados);
	$dados = stripslashes($dados);
	$dados = htmlspecialchars($dados);
	return $dados;
  }

if(!empty( $_SESSION['login'])){
    header ('Location: profile.php');
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
      $nomeErr = "Password is required!";
    } else {
      $nome = test_input($_POST["password"]);
    }
    
    if ($passwordErr =="" AND $emailErr == ""){
      $query = "SELECT * FROM contatos WHERE email='$_POST[email]' AND  password='$_POST[password]'";
      $result = mysqli_query ($conn,$query);
      $row = mysqli_fetch_assoc ($result);
      if (mysqli_num_rows($result) > 0){
        $_SESSION['nome'] = $row['nome'];
        $_SESSION['login'] = TRUE;
        header ('Location: profile.php');
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <style>
      body {
        margin-left: 10px;
        background: rgb(9,9,121);
        background: linear-gradient(90deg, rgba(9,9,121,1) 35%, rgba(0,174,209,1) 100%);
        color: white;
      }

      .form-control {
        width: 30%;
      }
      
    </style>
    <title>Login</title> 
  </head>

  <body>
    <main>

      
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
      <?php } ?>

      <form name="frmLogin" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">          
          <h1>Login</h1>
          <div class="mb-3">
            <label class="form-label">Email: </label>
            <input type="email" class="form-control" name="email"  placeholder="Email" value="<?php echo $email; ?>" required autofocus>
          </div>
          <div class="mb-3">
            <label class="form-label">Password: </label>
            <input type="password" class="form-control" name="password" placeholder="Password" required>
          </div>
          <div class="mb-3">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
          <p>Don't have an account? <a href="register.php">Register</a></p>
      </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>

<?php
  mysqli_close($conn);
?>