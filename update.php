<?php
session_start();

ini_set('default_charset', 'UTF-8');

if( $_SESSION['login'] == TRUE){

include ("databaseConnection.php");

$nomeErr = $emailErr = $birthdateErr = "";
$nome = $email = $birthdate = "";
$count = 0;

switch ($_SERVER["REQUEST_METHOD"]){
	case 'POST':
		$memberNumber = $_POST['memberNumber'];
		break;
	case 'GET':
		$memberNumber = $_GET['memberNumber'];
		break;
}

function test_input($dados) {
	$dados = trim($dados);
	$dados = stripslashes($dados);
	$dados = htmlspecialchars($dados);
	return $dados;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {

	if (empty($_POST["nome"])) {
		$nomeErr = "<strong>Do not remove the Name.</strong> Please insert a valid Name!";
	} else {
		$nome = test_input($_POST["nome"]);
    if (!preg_match("/^([^[:punct:]\d]+)$/",$nome)) {
		  $nomeErr = "Only letters and white space allowed!";
		}
	}
	  
	if (empty($_POST["email"])) {
		$emailErr = "<strong>Do not remove Email.</strong> Please insert a valid Email!";
	} else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format!";
		}
	}

  if (empty($_POST["birthdate"])) {
		$birthdateErr = "<strong>Do not remove Birthdate.</strong> Please insert a valid Birthdate!";
	} else {
    $birthdate = test_input($_POST["birthdate"]);
	}

	if ($nomeErr == "" AND $emailErr == "" AND $birthdateErr == ""){
		$query = "UPDATE contatos SET nome = '$nome', email = '$email', birthdate = '$birthdate' WHERE memberNumber = $memberNumber";
		$result = mysqli_query ($conn, $query);	
	}

}

$query = "SELECT * FROM contatos WHERE memberNumber=$memberNumber";
$result = mysqli_query ($conn, $query);
$row = mysqli_fetch_assoc ($result);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="style2.css" rel="stylesheet">
    <link href="read2.css" rel="stylesheet">

    <title>Alter data</title>
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

      <script>
          // Função para exibir o alerta no Chrome
          function showAlert(message) {
            if (navigator.userAgent.indexOf("Chrome") != -1) {
              alert(message);
            }
          }

          // Verificar se há sucesso ou erros e exibir o alerta correspondente
          <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $nomeErr == "" && $emailErr == "" && $birthdateErr == "") { ?>
            showAlert("Data updated successfully");
          <?php } elseif ($nomeErr != "" || $emailErr != "" || $birthdateErr != "") { ?>
            var errorMessage = "Alert!\n\n";
            <?php if ($nomeErr != "") { ?>
              errorMessage += "<?php echo $nomeErr ?>\n";
            <?php } ?>
            <?php if ($emailErr != "") { ?>
              errorMessage += "<?php echo $emailErr ?>\n";
            <?php } ?>
            <?php if ($birthdateErr != "") { ?>
              errorMessage += "<?php echo $birthdateErr ?>\n";
            <?php } ?>
            showAlert(errorMessage);
          <?php } ?>
      </script>

    <div>
      <form name="frmInserir" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="mb-3">
            <label class="form-label" for="nome">Name </label>
            <input name="nome" type="text" class="form-control" value="<?php echo $row['nome'];?>" placeholder="Name"/>
          </div>

          <div class="mb-3">
            <label class="form-label" for="email">Email </label>
            <input name="email" type="email" class="form-control" value="<?php echo $row['email'];?>" placeholder="Email"/>
          </div>

          <div class="mb-3">
            <label class="form-label" for="birthdate">Birthdate </label>
            <input name="birthdate" type="birthdate" class="form-control" value="<?php echo $row['birthdate'];?>" placeholder="Birthdate"/>
          </div>

          <div class="mb-3">
            <input name="memberNumber" type="hidden" value="<?PHP echo $memberNumber; ?>" />
            <button class="btn btn-primary" name="alterar" type="submit" >Save</button>
            <button class="btn btn-primary" name="limpar" type="reset" >Reset</button>
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

} else {
  header ('Location: loginAuthentication.php');
} 
?>