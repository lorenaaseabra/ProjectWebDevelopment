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
    <!-- insert here the reference to stylesheet file -->
    <link href="style.css" rel="stylesheet">
    <link href="read.css" rel="stylesheet">
    <title>UPDATE</title>
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
          <form name="frmPesquisa" method="post" action="read.php">
            <input type="text" placeholder="Search" aria-label="Search" name="pesquisa">
            <button type="submit">Search</button>
          </form>

          <!-- search form -->

        </div>
      </nav>
      <!-- /.navigation bar -->
    </header>
    <main>

    <div><!-- info -->
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
    </div><!-- /.info -->

    <div><!-- contentor do formulario --> 
        <form name="frmInserir" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div>
              <label for="nome">Name </label>
              <div>
                <input name="nome" type="text" value="<?php echo $row['nome'];?>" placeholder="Name"/>
              </div>
            </div>
            <div>
              <label for="email">Email </label>
              <div>
                <input name="email" type="email" value="<?php echo $row['email'];?>" placeholder="Email"/>
              </div>
            </div>
            <div>
              <div>
                <div>
					<input name="memberNumber" type="hidden" value="<?PHP echo $memberNumber; ?>" />
					<button name="alterar" type="submit" >Save</button>
					<button name="limpar" type="reset" >Reset</button>
					<a href="read.php">Back to List</a>
                </div>
              </div>
            </div>
        </form>
      </div><!-- /.container -->


    </main>	
	</body>
</html>
<?php
// close connection
mysqli_close ($conn);

} else {
  header ('Location: loginAuthentication.php');
} 
?>