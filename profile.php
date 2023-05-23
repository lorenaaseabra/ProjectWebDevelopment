<?php
//initialize session
session_start();

// PHP charset
ini_set('default_charset', 'UTF-8');

if( $_SESSION['login'] == TRUE){

// database connection
include ("databaseConnect.php");

// intialize variables
$nameErr = $emailErr = "";
$name = $email = "";

switch ($_SERVER["REQUEST_METHOD"]){
	case 'POST':
		$codigo = $_POST['codigo'];
		break;
	case 'GET':
		$codigo = $_GET['codigo'];
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

	if (empty($_POST["name"])) {
		$nameErr = "<strong>Do not remove the Name.</strong> Please insert a valid Name!";
	} else {
		$name = test_input($_POST["name"]);
    if (!preg_match("/^([^[:punct:]\d]+)$/",$name)) {
		  $nameErr = "Only letters and white space allowed!";
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

	if ($nameErr =="" AND $emailErr == ""){
		$query = "UPDATE contatos SET name = '$name', email = '$email' WHERE codigo = $codigo";
		$result = mysqli_query ($conn, $query);	
	}

}

$query = "SELECT * FROM contatos WHERE codigo=$codigo";
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
    <!-- insert here the reference to stylesheet file -->
    
    <!-- general css -->
    <link rel="stylesheet" href="./css/style.css">

    <!-- own css -->
    <link rel="stylesheet" href="./css/profile.css">
    <title>User profile</title>
  </head>

  <body>

    <main>
      <div> 
        <legend><strong>Update</strong></legend>
      </div>

    <div><!-- info -->
		<?php
		  	if($_SERVER["REQUEST_METHOD"] == "POST" AND $nameErr =="" AND $emailErr == "") {
		?>
          <div >
            <h4>Info!</h4>
            <hr>
            Data were updated.
          </div>
        <?php
            }	
        ?>
		<?php if($nameErr !="" OR $emailErr != "") { ?>
            <div">
			<h4>Alert!</h4>
              <hr>
              <p><?PHP echo $nameErr ?></p>
              <p><?PHP echo $emailErr ?></p> 
            </div>
        <?php }	?>
    </div><!-- /.info -->

    <div><!-- contentor do formulario --> 
        <form name="frmInserir" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div>
              <label for="name">Name </label>
              <div>
                <input name="name" type="text" value="<?php echo $row['name'];?>" placeholder="Name"/>
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
                  <input name="codigo" type="hidden" value="<?PHP echo $codigo; ?>" />
                  <button name="alterar" type="submit" >Save</button>
                  <button name="limpar" type="reset" >Reset</button>
                  <a href="list.php">Back to List</a>
                </div>
              </div>
            </div>
        </form>
      </div>
    </main>	
	</body>
</html>
<?php
// close connection
mysqli_close ($conn);

} else {
  header ('Location: profile.php');
} 
?>