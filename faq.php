<?php
include "fnwebsite.php";
include "db.inc.php";
include "card.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <title>Index</title>
    <script src="JS/faq.js"></script>
</head>
<body>
    <?php
        if (isset($_SESSION['username'])) {
            loggedinnavbar();
            if (isset($_POST['zoeken'])) {
                $filter = $_POST['zoeken'];
                $object = new Dbh();
                $db = $object->connect();
                $sql = $db->prepare("SELECT Titel, Beschrijving, Afbeelding, id FROM projecten WHERE User LIKE '%$filter%'");
                // Execute query
                $sql->execute();            
                /* Fetch all of the values of the first column */
                $card_data = $sql->fetchAll();
            
                for ($i = 0; $i < count($card_data); $i++) {
                    $thumbnail = strval($card_data[$i][2]);
                    $thumbnail_url = "ProjectThumbnails/" . "$thumbnail";
                    $titel = strval($card_data[$i][0]);
                    $beschrijving = strval($card_data[$i][1]);
                    $id = strval($card_data[$i][3]);
    ?>

    <?php
        }
        }
        } else {
            navbar();
        }
    ?>

<div class="container faqcontainer">
           
<div class="row heading-row">
            <div class="col-12">
                <h1 class="title text-center">VEELGESTELDE VRAGEN</h1>
            </div>
</div>
            
            <div class="row">
                <div class="faq">
                    <br>
                    <div class="tekstcolor">
                        <button class="faqbutton but1" onclick="myFunction()"><i class="fas fa-plus-circle"></i> Hoe maak ik een account aan?</button>
                        <div id="myDIV">    
                            Je kan een account aanmaken door je <a href="registreer.php">hier</a> te registeren. Tijdens het registreren moet je je naam, achternaam, email van school, gebruikersnaam en een wachtwoord invoeren. Na het invoeren van je gegevens ontvang je een email om je account te activeren, na de activatie kan je <a href="login.php">hier</a> inloggen. 
                        </div>
                    </div>
                    <hr>
                    <div>
                        <button class="faqbutton" onclick="myFunction2()"><i class="fas fa-plus-circle"></i> Hoe kan ik inloggen?</button>
                        <div id="myDIV2">    
                        Om te kunnen inloggen moet je je eerste registreren. Als je al geregistreerd hebt, kan je <a href="login.php">hier</a> inloggen met je gebruikersnaam en wachtwoord.
                        </div>
                    </div>
                </div>
            </div>
</body>
</html>
