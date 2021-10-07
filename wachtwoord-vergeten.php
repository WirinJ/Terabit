<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
	<link rel="stylesheet" href="CSS/login.css">
    <title>Terabit - Wachtwoord vergeten</title>
	
</head>
<body>
  
    <?php
include 'fnwebsite.php';
date_default_timezone_set('Europe/Amsterdam');
navbar();
	$connect = new PDO("mysql:host=localhost;dbname=terabit", "root", "");
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
    if (isset($_POST['Submit'])) {
        $WW = md5($_POST['wachtwoord']);
        $WWS = md5($_POST['wachtwoords']);
     
      if ($WW == $WWS) {
          $query = "UPDATE gebruikers SET wachtwoord = :ww WHERE username = :user";
          $result = $connect->prepare($query);
          $result->execute(array(
              ':ww' => $WW,
              ':user' => $_SESSION['username']
          ));
          if ($result) {
            session_start();
            session_destroy();

            header("Location: login.php");
          }
          
      } else {
        echo '<script>
        alert("Je wachtwoorden kloppen niet het moet beide hetzelfde zijn!");
        window.location.href="settings.php";
       </script>';
      }
    }

    if (isset($_POST['Vergeten'])) {
        $email = $_POST['email'];
        $user = $_POST['username'];
        $sql1 = "SELECT COUNT(Email) AS num FROM gebruikers WHERE Email = :Email";
        $stmt1 = $connect->prepare($sql1);
        $stmt1->bindValue(':Email', $email);
        $stmt1->execute();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $sql = "SELECT COUNT(username) AS num FROM gebruikers WHERE username = :username";
        $stmt = $connect->prepare($sql);
        $stmt->bindValue(':username', $user);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row1['num'] > 0 || $row['num'] > 0)
        {
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->SMTPDebug = 0;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'ssl';
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 465;
                $mail->IsHTML(true);
                $mail->Username = 'terrabit2021@gmail.com';
                $mail->Password = 'Terrabit134.';
                $mail->SetFrom('terrabit2021@gmail.com');
                $mail->Subject = 'Wachtwoord vergeten';
                $mail->Body = 'Hoi ' . $user . ' <br>
                Wat jammer dat je wachtwoord bent vergeten <br>
                Klik op wachtwoord vergeten om je wachtwoord te resetten: <a href=wachtwoord-vergeten.php?email=' . $email . '>Wachtwoord vergeten?</a>';
                $mail->AddAddress($email);
                if (!$mail->Send())
                {
                    echo "er is iets fout gegaan bij het versturen vn de mail";
                }
                else
                {
                    echo "Message has been sent";
                }
    
                echo '<script>
     alert("Je krijgt een link gestuurd naar je mail");
    window.location.href="login.php";
    </script>';
            }
        }

        if(isset($_GET['email'])) {
            $sql2 = "SELECT COUNT(Email) AS num FROM gebruikers WHERE Email = :Email";
            $stmt2 = $connect->prepare($sql2);
            $stmt2->bindValue(':Email', $_GET['email']);
            $stmt2->execute();
            if ($stmt2) {
                echo '
                <br><center><div class="wrapper">
			     <div class="title">
			     Wachtwoord resetten</div>
	          <form action="" method="POST">
               <div class="field">
				<input type="password" name="wachtwoord" id="password" required>
				<label>Password</label>
				<i class="far fa-eye" id="togglePassword"></i>
			  </div>
              <div class="field">
				<input type="password" name="wachtwoords" id="password" required>
				<label>Password</label>
				<i class="far fa-eye" id="togglePassword"></i>
			  </div>
              <div class="field">
              <input type="submit" name="Submit" value="Bevestig">
              </div> </form></center>';
          
             if (isset($_POST['Submit'])) {
                $WW = md5($_POST['wachtwoord']);
                $WWS = md5($_POST['wachtwoords']);
             
              if ($WW == $WWS) {
                  $query = "UPDATE gebruikers SET wachtwoord = :ww WHERE Email = :email";
                  $result = $connect->prepare($query);
                  $result->execute(array(
                      ':ww' => $WW,
                      ':email' => $_GET['email']
                  ));
                  if ($result) {
                        
                echo '<script>
                alert("Je wachtwoord is gereset je kan nu weer inloggen!");
               window.location.href="login.php";
               </script>';
                  }
              } else {
                echo '<script>
                alert("Je wachtwoords kloppen niet het beide hetzelfde zijn!");
               </script>';
              }
            }
        } 
    } else {
	echo '<br><center><div class="wrapper">
	<div class="title">
	Wachtwoord vergeten?</div>
	<form style="height: 184px;" action="" method="POST">
	<div class="field">
    <input type="email" name="email" 
    pattern="^[\d]+@+(talnet\.nl|bitacademy\.nl)$" 
    title="Als je wilt aanmelden moet je met @talnet.nl of @bitacademy.nl aanmelden" required>
    <label>Email</label>
    </div>
    <div class="field">
    <input type="text" name="username" pattern=".{3,14}" title="Minstens 3 letters max 12"  required>
    <label>Gebruikersnaam</label>
    </div>
    <div style="left: -1px; top: 13px; width: 163px;"  class="field">
    <input type="submit" name="Vergeten" value="Bevestig">
    </div>
	</form>
	</div></center>';
        }
?>
</body>
</html>

