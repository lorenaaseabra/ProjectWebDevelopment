<?php
//initialize session
session_start();

// PHP charset
ini_set('default_charset', 'UTF-8');

if( $_SESSION['login'] == TRUE){

// database connection
include ("databaseConnect.php");

// intialize variables
$nameErr = $emailErr = $birthdate = $passwordErr= "";
$name = $email = $birthdate = $password = $hidden = $disabled = "";

// "cleaning data"
function test_input($dados) {
	$dados = trim($dados);
	$dados = stripslashes($dados);
	$dados = htmlspecialchars($dados);
	return $dados;
  }

if($_SERVER["REQUEST_METHOD"] == "POST") {

	if (empty($_POST["name"])) {
		$nameErr = "name is required!";
	} 
    else{
      $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
        if (!preg_match("/^([^[:punct:]\d]+)$/",$name)) {
            $nameErr = "Only letters and white space allowed.";
        }
	}
	  
	if (empty($_POST["email"])) {
		$emailErr = "Email is required!";
	} 
    else{
      $email = test_input($_POST["email"]);
      // verifica o formato do email
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format!";
      }
    }

    if (empty($_POST["birthdate"])) {
		$birthdateErr = "Birthdate is required!";
	} 

    
    if (strlen($_POST["password"]) < 5) {    
      $passwordErr = "Password must have min. 5 characters!";
    } 
    elseif ($_POST["password"] != $_POST["rpassword"]){
        $passwordErr = "Passwords does not match!";
    } 
    else{ 
        $password = test_input($_POST["password"]);
    }

	if ($nameErr =="" AND $emailErr == "" AND $passwordErr == ""){
		$query = "INSERT INTO contatos (name, email, birthdate, password)
		VALUES ('$name',  '$email', '$birthdate', '$password')";
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
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- general css -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- own css -->
    <link rel="stylesheet" href="./css/registration.css">
    <title>Register a new user</title>
  </head>

  <body>

    <main>

      <div><!-- info -->
        <?php
          if($_SERVER["REQUEST_METHOD"] == "POST" AND $nameErr =="" AND $emailErr == "" AND $birthdateErr == "" AND $passwordErr =="") {
        ?>
          <div>
            <h4 >Info!</h4>
            <hr>
            Data were sent to database.
          </div>
        <?php
            }	
        ?>
        <?php if($nameErr !="" OR $emailErr != "" OR $birthdateErr !=""OR $passwordErr !="") { ?>
          <div>
              <h4>Alert!</h4>
              <hr>
              <p><?PHP echo $nameErr ?></p>
              <p><?PHP echo $emailErr ?></p>
              <p><?PHP echo $birthdateErr ?></p>
              <p><?PHP echo $passwordErr ?></p>
          </div>
        <?php }	?>
      </div><!-- /.info -->

      <div>
        <form name="frmInserir" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="input-item">
                <label for="name">name: </label><br>
                <input type="text" id="name" name="name" value="<?php echo $name;?>" placeholder="name" <?php echo $disabled ?>>
            </div>
            <br>
            <div class="input-item">
                <label for="email">Email: </label><br>
                <input type="email" id="email" name="email" value="<?php echo $email;?>" placeholder="Email" <?php echo $disabled ?>>
            </div>
            <br>
            <div class="input-item">
                <label for="birthdate">Birthdate: </label><br>
                <input type="date" id="birthdate" name="birthdate" value="<?php echo $birthdate;?>" placeholder="Birthdate" <?php echo $disabled ?>>
            </div>
            <br>

            <div <?php echo $hidden ?>>
                <div class="input-item">
                    <label for="password">Password: </label><br>
                    <input type="password" id="password" name="password" placeholder="Password [min. 5 characters]"/>
                </div>
            </div>
            <br>
            <div <?php echo $hidden ?>>
              <label>Repeat password </label>
              <div>
                <input name="rpassword" type="password" placeholder="Repeat password"/>
              </div>
            </div>
            <div>
              <div>
                <div>	
                  <button name="gravar" type="submit" <?php echo $disabled ?>>Save</button>
                  <button name="limpar" type="reset" >Reset</button>
                  <a href="read.php">Back to list</a>
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
  header ('Location: registration.php');
} 
?>