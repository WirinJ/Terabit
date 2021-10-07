<?php
function navbar() {
  echo  '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CSS/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" >
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Terabit</title>
</head>
<body>
    <nav class="topnav">
        <div class="logo">
            <a href="index.php">Terabit</a>
        </div>

        <div>
              <form method="POST" action="zoeken.php">
                  <input class="zoekb" type="text" placeholder="Zoek projecten op gebruikersnaam..." name="zoeken">
              </form>
          </div>

        <div class="knoppen">
            <div class="posbut"> 
            <button type="button" class="knop">
            <a style="color: white; text-decoration: none;" href="index.php"> <i style="font-size: 22px;" class="fas fa-home"></i> Home</button></a>

           
                <button type="button" class="knop">
                <a style="color: white; text-decoration: none;" href="explore.php"><i class="fas fa-project-diagram"></i> Alle projecten</button></a>

                <button type="button" class="knop">
                <a style="color: white; text-decoration: none;" href="faq.php"><i class="fas fa-scroll"></i> FAQ</button></a>
            </div>
        </div>
            
            <div class="knoppen">
                <form action=" method="POST">
                <button type="button" class="knop">
                <a style="color: white; text-decoration: none;" href="login.php"><i style="font-size: 22px;" class="fas fa-sign-in-alt"></i> Login</button></a>
                    
                <button type="button" class="knop">
                <a style="color: white; text-decoration: none;" href="registreer.php"><i style="font-size: 18px;" class="fas fa-user-plus"></i> Registreer</button></a>
                </form>
            </div>
        
    </nav> 


</body>
</html>';
}

function loggedinnavbar() {
    $user = $_SESSION['username'];
    echo  '<!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" type="text/css" href="CSS/navbar.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" >
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <title>Terabit</title>
  </head>
  <body>
      <nav class="topnav">
          <div class="logo">
              <a href="index.php">Terabit</a>
          </div>
  
          <div class="zoekbalk">
              <form method="POST" action="zoeken.php">
                  <input class="zoekb" type="text" placeholder="Zoek projecten op gebruikersnaam..." name="zoeken">
              </form>
          </div>

          <div class="knoppen">
            <div class="posbut"> 
                <button type="button" class="knop">
                <a style="color: white; text-decoration: none;" href="index.php"> <i style="font-size: 21px;" class="fas fa-home"></i> Home</button></a>

         
              <button type="button" class="knop">
              <a style="color: white; text-decoration: none;" href="explore.php"><i class="fas fa-project-diagram"></i> Alle projecten</button></a>

              <button type="button" class="knop">
              <a style="color: white; text-decoration: none;" href="faq.php"><i class="fas fa-scroll"></i> FAQ</button></a>

              <button type="button" class="knop" data-bs-toggle="modal" data-bs-target="#projectToevoegen">
              <a style="color: white; text-decoration: none;"><i style="font-size: 18px;" class="fa fa-plus"></i> Nieuw project</button></a>

          </div>
      </div>

        <div class="credss">
            <div class="creds">
              ';
              	$connect = new PDO("mysql:host=localhost;dbname=terabit", "root", "");
             	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $user = $_SESSION["username"];
              $query = $connect->prepare("SELECT credits FROM gebruikers WHERE username = :id ");
              $query->execute(array(
                  ':id' => $user
              ));
              if ($eerste = $query->fetch()) {
                echo '  <img src="images/credit.png"><p>' .$eerste["credits"]. '</p>
              </div>';
              }
              echo "
          </div>
  
          <div class='dropd'>
              <ul id='navUl'>    
                  <li><i class='fas fa-user-circle'></i> <i class='fas fa-chevron-down'></i>
                      <ul id='navUl'>
                        <p class='gebr'>" .$_SESSION['username']. "</p>
                          <hr>
                          <li><a href='profiel.php?project-author=$user' ><i class='fas fa-user'></i> &nbsp; Profiel</a></li>
                          <li><a href='#'><i class='fas fa-shopping-basket'></i> &nbsp; Bit shop</a></li>
                          <li><a href='#'><i class='fas fa-cog'></i> &nbsp; Instellingen</a></li>
                          <hr>
                          <form method='POST' action='logout.php'>
                          <a class='uitloggen' href='#'> <i class='fas fa-sign-out-alt'>
                          </i><button class='loguit text-left' value='logout' name='logoutsubmit'>Uitloggen</button></a>
                          </form>
                      </ul>
                  </li>
              </ul>
          </div>
      </nav> 
  
      <div class='midden'>
      </div>
  
  </body>
  </html>";
  }
  function userlogout()
{
    if (isset($_POST['logoutsubmit']))
    {
        session_start();
        session_destroy();
        header("Refresh:0");
        exit();
    }
}


?>
