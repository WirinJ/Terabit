<?php

include "fnwebsite.php";
include "db.inc.php";
include "card.php";

session_start();
$object = new Dbh();
$connect = $object->connect();

?>

<DOCTYPE html>
    <html>

    <head>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="CSS/explore.css">
    </head>

    <body>
        <?php
        if (isset($_SESSION['username'])) {
            loggedinnavbar();
                if (isset($_POST['zoeken'])) {
                    $zoek = $_POST['zoeken']
                    ?>
                    <div class="container">
                   <div class="row">
                  
                   <?php
                   $search = "SELECT username FROM gebruikers WHERE username LIKE '%$zoek%'"; 
                   $stmt = $connect->prepare($search);
                   $stmt->execute();
                   $row = $stmt->fetch(PDO::FETCH_ASSOC);
                   if ($row > 0) {
                       ?>
                           <div class="row heading-row">
                               <div class="col-12">
                                   <h1 class="title text-center">PROJECTEN VAN `<?= $_POST['zoeken'] ?>`</h1>
                               </div>
                           </div>
                       <?php
                               $filter = $_POST['zoeken'];
                               $sql = $connect->prepare("SELECT Titel, Beschrijving, Afbeelding, id, likes FROM projecten WHERE User LIKE '%$filter%'");
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
                                   $likes = strval($card_data[$i][4]);
                               
                               ?>
                                       <div class="col-md-3 col-sm-6">
                                           <div class="card text-center card h-100">
                                               <div class="card-block h-100">
                                                       <img style="max-height: 150px;" src="<?= $thumbnail_url ?>" alt="" class="img-fluid project-image card-img-top">
                                                   <div class="card-title">
                                                       <h4><?= $titel ?></h4>
                                                       <div class="card-text">
                                                           <center><a href="project_showcase.php?id=<?php echo "$id"; ?>" class="btn btn-success btn-card">Bekijk project</a></center>
                                                           <i class="far fa-heart"></i> <?= $likes ?> 
                                                           <?php $statement = $connect->prepare("SELECT COUNT(`message`) FROM comments WHERE post_id = $id");
                                            $statement->execute(array());
                                            if ($eerste = $statement->fetch()) {
                                             ?>
                                            <i class="far fa-comment-alt"></i> <?= $eerste['COUNT(`message`)'] ?> 
                                            <?php } ?>
                                                       </div>
                                                   </div>
                                               </div>
                   
                                           </div>
                                       </div>
                               <?php
                               }
                               } else {
                                   ?>
                                   <div class="row heading-row">
                               <div class="col-12">
                                   <h1 class="title text-center">GEBRUIKER IS NIET GEVONDEN EN/OF HEEFT NOG GEEN PROJECTEN</h1>
                               </div>
                           </div>
                           <?php
                               }
                           }                 
        } else {
            navbar();
            if (isset($_POST['zoeken'])) {
                $zoek = $_POST['zoeken']
                ?>
                <div class="container">
               <div class="row">
               <?php
               $search = "SELECT username FROM gebruikers WHERE username LIKE '%$zoek%'"; 
               $stmt = $connect->prepare($search);
               $stmt->execute();
               $row = $stmt->fetch(PDO::FETCH_ASSOC);
               if ($row > 0) {
                   ?>
                       <div class="row heading-row">
                           <div class="col-12">
                               <h1 class="title text-center">PROJECTEN VAN `<?= $_POST['zoeken'] ?>`</h1>
                           </div>
                       </div>
                   <?php
                           $filter = $_POST['zoeken'];
                           $sql = $connect->prepare("SELECT Titel, Beschrijving, Afbeelding, id, likes FROM projecten WHERE User LIKE '%$filter%'");
                           // Execute query
                           $sql->execute();            
                           /* Fetch all of the values of the first column */
                           $card_data = $sql->fetchAll();
                       
                       
                           for ($i = 0; $i < count($card_data); $i++) {
                               $thumbnail = strval($card_data[$i][2]);
                               $thumbnail_url = "ProjectThumbnails/" . "$thumbnail";
                               $titel = strval($card_data[$i][0]);
                               $id = strval($card_data[$i][3]);
                               $likes = strval($card_data[$i][4]);
                               $beschrijving = strval($card_data[$i][1]);
                           
                           ?>
                                   <div class="col-md-3 col-sm-6">
                                       <div class="card text-center card h-100">
                                           <div class="card-block h-100">
                                                   <img style="max-height: 150px;" src="<?= $thumbnail_url ?>" alt="" class="img-fluid project-image card-img-top">
                                               <div class="card-title">
                                                   <h4><?= $titel ?></h4>
                                                   <div class="card-text">
                                                       <center><a href="project_showcase.php?id=<?php echo "$id"; ?>" class="btn btn-success btn-card">Bekijk project</a></center>
                                                       <i class="far fa-heart"></i> <?= $likes ?> 
                                                       <?php $statement = $connect->prepare("SELECT COUNT(`message`) FROM comments WHERE post_id = $id");
                                            $statement->execute(array());
                                            if ($eerste = $statement->fetch()) {
                                             ?>
                                            <i class="far fa-comment-alt"></i> <?= $eerste['COUNT(`message`)'] ?> 
                                            <?php } ?>
                                                   </div>
                                               </div>
                                           </div>
               
                                       </div>
                                   </div>
                           <?php
                           }
                           } else {
                               ?>
                               <div class="row heading-row">
                           <div class="col-12">
                               <h1 class="title text-center">GEBRUIKER IS NIET GEVONDEN EN/OF HEEFT NOG GEEN PROJECTEN</h1>
                           </div>
                       </div>
                       <?php
                           }
                       }
        }

        ?>
    </body>

    </html>
