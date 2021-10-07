<!DOCTYPE html>

<?php

include "fnwebsite.php";
include_once 'db.inc.php';
$object = new Dbh();
$connect = $object->connect();

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" >
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Terabit</title>
</head>
<body>
<?php
  navbar();
  if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    // Verify data
    $email = $_GET['email']; // Set email variable
    $hash = $_GET['hash']; // Set hash variable
    $search = "SELECT email, hash, active FROM gebruikers WHERE email='".$email."' AND hash='".$hash."' AND active='0'"; 
    $stmt = $connect->prepare($search);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row > 0){
        $qeury = "UPDATE gebruikers SET active= '1' WHERE Email = :email AND hash = :hash AND active = '0' ";
        $run = $connect->prepare($qeury);
        $run->execute(array(
           ':email' => $email,
           ':hash' =>  $hash
        ));
        echo '<script>
        alert("Je acccount is geactiveerd");
       window.location.href="login.php";
       </script>';
    }else{
        echo '<script>
        alert("Je acccount is all geactiveerd");
       window.location.href="login.php";
       </script>';
    }
}else{
    // Invalid approach
    echo '<script>
    alert("Gebruik de link die gestuurd is naar je mail!");
   window.location.href="login.php";
   </script>';
}
?>
</body>
</html>