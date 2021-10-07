<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include 'fnwebsite.php';
include "db.inc.php";

$object = new Dbh();
$connect = $object->connect();
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
    <title>Terabit - Registreren</title>
</head>
<body>
 <?php

  if (isset($_SESSION['username'])) {
    header('Location: index.php');
    die();
  } else {
    navbar();
  }

if (isset($_POST['aanmelden']))
{
    $naam = $_POST['Naam'];
    $achternaam = $_POST['Achternaam'];
    $email = $_POST['email'];
    $user = $_POST['username'];
    $WW = md5($_POST['wachtwoord']);
    $sql = "SELECT COUNT(username) AS num FROM gebruikers WHERE username = :username";
    $stmt = $connect->prepare($sql);
    $stmt->bindValue(':username', $user);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $hash = md5(rand(0, 1000));
    $sql1 = "SELECT COUNT(Email) AS num FROM gebruikers WHERE Email = :Email";
    $stmt1 = $connect->prepare($sql1);
    $stmt1->bindValue(':Email', $email);
    $stmt1->execute();
    $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    $structure1 = "./users/$user/profilePicture/";
    $structure2 = "./Users/$user/projects/"; 
    $structure3 = "./users/$user/profilePicture/profile-placeholder.jpg";
    $profile_placeholder = "./Images/profile-placeholder.jpg";
    if ($row['num'] > 0)
    {
        echo '<script>alert("Gebruikersnaam bestaat all")</script>';
    }
    elseif ($row1['num'] > 0)
    {
        echo '<script>alert("Email bestaat all")</script>';
    }
    else
    {
        $sql = "INSERT INTO `gebruikers` (`Naam`, `Achternaam`, `Email`, `username`, `wachtwoord`, `hash`) 
    VALUES (:Naam, :Achternaam, :Email, :username, :wachtwoord, :hash) ";
        $sql_run = $connect->prepare($sql);
        $result = $sql_run->execute(array(
            ":Naam" => $naam,
            ":Achternaam" => $achternaam,
            ":Email" => $email,
            ":username" => $user,
            ":wachtwoord" => $WW,
            ":hash" => $hash
        ));
        if ($result)
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
            $mail->Subject = 'Email verification';
            $mail->Body = 'Hoi ' . $user . ' 
      Leuk dat je wilt aanmelden bij terrabit!
      hier is je bevestig link: <a href=verify.php?email=' . $email . '&hash=' . $hash . '>Activeer je account</a>';
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
 alert("Activeer je account via de mail");
 window.location.href="login.php";
</script>';

        }
        mkdir($structure1, 0777, true);
        mkdir($structure2, 0777, true);
        copy($profile_placeholder, $structure3);

    }
}
?>
<br><center><div class="wrapper">
<div class="title">
 Registreer</div>
<form action="" method="POST">
<div class="field">
    <input type="text" name="Naam" pattern="[a-zA-Z]{2,20}" required>
    <label>Voornaam</label>
  </div>
  <div class="field">
    <input type="text" name="Achternaam" pattern="[a-zA-Z]{2,20}" required>
    <label>Achternaam</label>
  </div>
  <div class="field">
    <input type="email" name="email" 
    pattern="^.*@+(talnet\.nl|bitacademy\.nl)$" title="Als je wilt aanmelden moet je met @talnet.nl of @bitacademy.nl aanmelden" required>
    <label>E-mail</label>
  </div>
  <div class="field">
    <input type="text" name="username" pattern=".{3,20}" title="Minstens 3, max 20 karakters"  required>
    <label>Gebruikersnaam</label>
  </div>
<div class="field">
    <input type="password" name="wachtwoord" id="password" pattern=".{8,}" title="Minstens 8 karakters" required>
    <label>Wachtwoord</label>
    <i class="far fa-eye" id="togglePassword"></i>
  </div><br><br>

 


<div class="content">
<div style="left: 3px;" class="field"><br>
    <input type="submit" name="aanmelden" value="Aanmelden">
  </div>
</form>
</div></center>';


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