<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
	<link rel="stylesheet" href="CSS/login.css">
    <title>Terabit - Login</title>
</head>
<body>
  
    <?php

	include 'fnwebsite.php';
	include_once 'db.inc.php';
	$object = new Dbh();
	$connect = $object->connect();
	
	if (isset($_SESSION['username'])) {
		header('Location: index.php');
		die();
	} else {
		navbar();
	}

	date_default_timezone_set('Europe/Amsterdam');
	$connect = new PDO("mysql:host=localhost;dbname=terabit", "root", "");
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
    if (isset($_POST['username'])) {
			 $query = "SELECT * FROM gebruikers WHERE username = :username AND wachtwoord = :wachtwoord AND active = '1'";
             $WW = md5($_POST['wachtwoord']);
			 $statement = $connect->prepare($query);
			 $statement->bindParam(':username', $_POST['username']);
			 $statement->bindParam(':wachtwoord', $WW);
			 $statement->execute(
			 );
			 $count = $statement->rowCount();
		    if ($count > 0) { 
				if (isset($_POST['remember'])) {
					setcookie('username',$_POST['username'],time()+30);
					setcookie('wachtwoord',$_POST['wachtwoord'],time()+30);
				} else {
					setcookie('username',$_POST['username'],30);
					setcookie('wachtwoord',$_POST['wachtwoord'],30);
				} 
							$_SESSION["username"] = $_POST["username"];
                            header("Location: index.php");			
			} else { 
				 echo "<script>
				 alert('Gebruikers/wachtwoord onjuist');
			   </script>";
			}
	}
	$username_cookie = "";
	$wachtwoord_cookie = "";
	$set_remember = "";
	if (isset($_COOKIE['username']) && isset($_COOKIE['wachtwoord'])) {
		$username_cookie = $_COOKIE['username'];
		$wachtwoord_cookie = $_COOKIE['wachtwoord'];
		$set_remember="checked='checked'";
	}

			echo '<br><center><div class="wrapper">
			<div class="title">
			 Login</div>
	  <form style="height: 270px;" action="" method="POST">
			  <div class="field">
				<input type="text" name="username" value="'.$username_cookie.'" required>
				<label>Gebruikersnaam</label>
			  </div>
	  <div class="field">
				<input type="password" name="wachtwoord" id="password" value="'.$wachtwoord_cookie.'" required>
				<label>Wachtwoord</label>
				<i class="far fa-eye" id="togglePassword"></i>
			  </div>
	  <div class="content">
				<div class="checkbox">
				  <input type="checkbox" name="remember" "'.$set_remember.'" id="remember-me" >
				  <label for="remember-me">Onthoud mij</label>
				</div>
	  <div class="pass-link">
	  <a href="Wachtwoord-vergeten.php">Wachtwoord vergeten?</a></div>
	  </div>
	  <div class="field">
				<input type="submit" value="Login">
			  </div>
	  <div class="signup-link">
	  Aanmelden? <a href="registreer.php">Registreer nu</a></div>
	  </form>
	  </div></center>';

?>
<script>
	const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');
togglePassword.addEventListener('click', function (e) {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
});
</script>  
</body>
</html>

