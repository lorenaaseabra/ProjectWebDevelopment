<?php
session_start();

ini_set('default_charset', 'UTF-8');

include ("databaseConnection.php");

$nomeErr = $emailErr = $passwordErr = $birthdateErr = $memberNumberErr = "";
$nome = $email = $password = $birthdate = $isManager = $hidden = $disabled = "";

$memberNumber = mt_rand(1000, 9999);

function test_input($dados) {
	$dados = trim($dados);
	$dados = stripslashes($dados);
	$dados = htmlspecialchars($dados);
	return $dados;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {

	if (empty($_POST["nome"])) {
		$nomeErr = "Name is required!";
	} else {
    $nome = test_input($_POST["nome"]);
    if (!preg_match("/^([^[:punct:]\d]+)$/",$nome)) {
        $nomeErr = "Only letters and white space allowed.";
    }
	}

  if (empty($_POST["birthdate"])) {
		$birthdateErr = "Birthdate is required!";
	} else {
    $birthdate = test_input($_POST["birthdate"]);
	}
	  
  if (empty($_POST["email"])) {
  $emailErr = "Email is required!";
  } else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format!";
    }
  }
    
  if (strlen($_POST["password"]) < 5) {    
      $passwordErr = "Password must have min. 5 characters!";
  } elseif ($_POST["password"] != $_POST["rpassword"]){
      $passwordErr = "Passwords does not match!";
  } else { 
      $password = test_input($_POST["password"]);
  }

  $isManager = isset($_POST['isManager']) ? 1 : 0;

	if ($nomeErr =="" AND $emailErr == "" AND $passwordErr == "" AND $memberNumberErr == "" AND $birthdateErr == ""){
		$query = "INSERT INTO contatos (memberNumber, nome, email, password, birthdate, isManager)
		VALUES ('$memberNumber', '$nome',  '$email', '$password', '$birthdate', '$isManager')";
    mysqli_query ($conn,$query);
    $disabled = "disabled";
    $hidden = "hidden";
	}
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style2.css">
    <link href="read2.css" rel="stylesheet">

    <title>Register</title>
  </head>

  <body>
    <main>
      <script>
        // Função para exibir o alerta no Chrome
        function showAlert(message) {
          if (navigator.userAgent.indexOf("Chrome") != -1) {
            alert(message);
          }
        }

        // Verificar se há sucesso ou erros e exibir o alerta correspondente
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $nomeErr == "" && $emailErr == "" && $passwordErr == "") { ?>
          showAlert("Your registration was successful!");
        <?php } elseif ($nomeErr != "" || $emailErr != "" || $passwordErr != "" || $birthdateErr != "") { ?>
          var errorMessage = "Alert!\n\n";
          <?php if ($nomeErr != "") { ?>
            errorMessage += "<?php echo $nomeErr ?>\n";
          <?php } ?>
          <?php if ($emailErr != "") { ?>
            errorMessage += "<?php echo $emailErr ?>\n";
          <?php } ?>
          <?php if ($passwordErr != "") { ?>
            errorMessage += "<?php echo $passwordErr ?>\n";
          <?php } ?>
          <?php if ($birthdateErr != "") { ?>
            errorMessage += "<?php echo $birthdateErr ?>\n";
          <?php } ?>
          showAlert(errorMessage);
        <?php } ?>
      </script>

      <div class="container">
        <form name="frmInserir" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <h1>Register</h1>
            <div class="mb-3">
              <label class="form-label">Name: </label>
              <input name="nome" type="text" class="form-control" value="<?php echo $nome;?>" placeholder="Name" <?php echo $disabled ?>>
            </div>

            <div class="mb-3">
              <label class="form-label">Email: </label>
              <input name="email" type="email" class="form-control" value="<?php echo $email;?>" placeholder="Email" <?php echo $disabled ?>>
            </div>

            <div class="mb-3" <?php echo $hidden ?>>
              <label class="form-label">Password: </label>
              <input name="password" type="password" class="form-control" placeholder="Password [min. 5 characters]"/>
            </div>

            <div class="mb-3" <?php echo $hidden ?>>
              <label class="form-label">Repeat password: </label>
              <input name="rpassword" type="password" class="form-control" placeholder="Repeat password"/>
            </div>

            <div class="mb-3">
              <label class="form-label">Birthdate: </label>
              <input name="birthdate" type="date" value="<?php echo $birthdate;?>" class="form-control"/>
            </div>

            <div class="mb-3">
              <label class="form-label">Manager? </label>
              <input name="isManager" type="checkbox" value="1" class="form-check-input"/>
            </div>

            <div>	
              <button class="btn btn-primary" name="gravar" type="submit" <?php echo $disabled ?>>Save</button>
              <button class="btn btn-primary" name="limpar" type="reset" >Reset</button>
              <p>Already have an account? <a href="loginAuthentication.php">Login</a></p>
            </div>

        </form>
      </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>
<?php
// close connection
mysqli_close ($conn);

?>
