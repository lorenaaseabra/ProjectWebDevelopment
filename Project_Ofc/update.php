<?php
//initialize session
session_start();

// PHP charset
ini_set('default_charset', 'UTF-8');

if( $_SESSION['login'] == TRUE){

// database connection
include ("databaseConnection.php");

// intialize variables
$nomeErr = $emailErr = "";
$nome = $email = "";

switch ($_SERVER["REQUEST_METHOD"]){
	case 'POST':
		$memberNumber = $_POST['memberNumber'];
		break;
	case 'GET':
		$memberNumber = $_GET['memberNumber'];
		break;
}

// "cleaning data"
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
    // check if name only contains letters and whitespace
    if (!preg_match("/^([^[:punct:]\d]+)$/",$nome)) {
		  $nomeErr = "Only letters and white space allowed!";
		}
	}
	  
	if (empty($_POST["email"])) {
		$emailErr = "<strong>Do not remove Email.</strong> Please insert a valid Email!";
	} else {
    $email = test_input($_POST["email"]);
    // verifica o formato do email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format!";
		}
	}

	if ($nomeErr =="" AND $emailErr == ""){
		$query = "UPDATE contatos SET nome = '$nome', email = '$email' WHERE memberNumber = $memberNumber";
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
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <link href="read.css" rel="stylesheet">

    <title>Alter data</title>
  </head>

  <body>
  <header>
      <nav>
        <div>
        <ul>
              <a href="profile.php">Profile</a>
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

    <div>
		<?php
		  	if($_SERVER["REQUEST_METHOD"] == "POST" AND $nomeErr =="" AND $emailErr == "") {
		?>
          <div >
            <h4>Info!</h4>
            <hr>
            Data were updated.
          </div>
        <?php
            }	
        ?>
		<?php if($nomeErr !="" OR $emailErr != "") { ?>
            <div">
			<h4>Alert!</h4>
              <hr>
              <p><?PHP echo $nomeErr ?></p>
              <p><?PHP echo $emailErr ?></p> 
            </div>
        <?php }	?>
    </div>

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