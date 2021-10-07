<?php

include "fnwebsite.php";
include "db.inc.php";
include "card.php";

session_start();
$object = new Dbh();
$connect = $object->connect();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terabit - Home</title>
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

    <div class="col-md-3 col-sm-6">
        <div class="card text-center card h-100">
            <div class="card-block h-100">
                <img src="<?= $thumbnail_url ?>" alt="" class="img-fluid project-image card-img-top">
                <div class="card-title">
                    <h4><?= $titel ?></h4>
                    <div class="card-text">
                        <a href="project_showcase.php?id=<?php echo "$id"; ?>" class="btn btn-success btn-card">Bekijk project</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        }
        }
        } else {
            navbar();
        }
    ?>

    <div class="container">
        

    <div class="row heading-row">
        <div class="col-12">
            <h1 class="title text-center">NIEUWSTE PROJECTEN</h1>
        </div>
    </div>

    <div class="modal fade" id="projectToevoegen" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header popup-heading"> 
                    <h5 class="modal-title popup-titel w-100 text-center" id="ModalTitle">Project toevoegen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="add_project_process.php" id="add-project-form" enctype="multipart/form-data">

                    <div class="form-outline mb-4">
                        <label for="=thumbnail">Selecteer thumbnail</label><br>
                        <input type="file" name='thumbnail' id="thumbnail" class="thumbnail" value='' required><br>
                    <div class="form-outline mb-4">
                </div>

                <input type="text" name='title' placeholder="Project titel" id="title" value='' class="form-control input-shadow" required>
            </div>

            <div class="form-outline mb-4">
                <label for="project-images">Selecteer project afbeeldingen</label>
                <input name="project-images[]" multiple="multiple" type="file" id="project-images" class="project-images" required>
            </div>

            <div class="form-outline mb-4">
                <textarea type="text" name='description' class="w-100 mb-40 input-shadow" placeholder="Project beschrijving" id="description" value='' rows="10" required></textarea><br>
            </div>

            <div class="form-outline mb-4">
                <textarea type="text" name='milestones' class="w-100 mb-40 input-shadow" placeholder="Typ hier je project milestones in met een nieuwe regel per milestone." id="milestones" value='' rows="10" required></textarea>
            </div>

            <div class="form-outline mb-4">
                <input type="text" name='source' placeholder="Link naar source code" id="source" value='' class="form-control input-shadow" />
            </div>

            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
            <button type="submit" name="add-project" form="add-project-form" value="add-project" class="btn btn-primary">Voeg toe</button>
        </div>
    </div>
    </div>
    </div>

    <div class="row">
        <?php                
                    $object = new Dbh();
                    $db = $object->connect();
                    $sql = $db->prepare("SELECT Titel, Beschrijving, Afbeelding, id, likes FROM projecten ORDER BY DATE DESC LIMIT 4");
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
                                        <img style="height: 200px; max-height: 200px;" src="<?= $thumbnail_url ?>" alt="" class="img-fluid project-image card-img-top">
                                    <div class="card-title">
                                        <h4><?= $titel ?></h4>
                                        <div class="card-text">
                                            <center><a href="project_showcase.php?id=<?php echo "$id"; ?>" class="btn btn-success btn-card">Bekijk project</a></center>
                                            <i class="far fa-heart e-icon"></i> <?= $likes ?> 
                                            <?php $statement = $connect->prepare("SELECT COUNT(`message`) FROM comments WHERE post_id = $id");
                                            $statement->execute(array());
                                            if ($eerste = $statement->fetch()) {
                                             ?>
                                            <i class="far fa-comment-alt e-icon"></i> <?= $eerste['COUNT(`message`)'] ?> 
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
            }
        ?>
</div>


<div class="row heading-row">
                <div class="col-12">
                    <h1 class="title text-center">MEESTE LIKES</h1>
                </div>
            </div>

            <div class="row">
            <?php   

                    $object = new Dbh();
                    $db = $object->connect();
                    $sql = $db->prepare("SELECT Titel, Beschrijving, Afbeelding, id, likes FROM projecten WHERE likes ORDER BY likes DESC LIMIT 4");
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
                                        <img style="max-height: 200px;" src="<?= $thumbnail_url ?>" alt="" class="img-fluid project-image card-img-top">
                                    <div class="card-title">
                                        <h4><?= $titel ?></h4>
                                        <div class="card-text">
                                            <center><a href="project_showcase.php?id=<?php echo "$id"; ?>" class="btn btn-success btn-card">Bekijk project</a></center>
                                            <i class="far fa-heart e-icon"></i> <?= $likes ?> 
                                            <?php $statement = $connect->prepare("SELECT COUNT(`message`) FROM comments WHERE post_id = $id");
                                            $statement->execute(array());
                                            if ($eerste = $statement->fetch()) {
                                             ?>
                                            <i class="far fa-comment-alt e-icon"></i> <?= $eerste['COUNT(`message`)'] ?> 
                                            <?php } ?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
            }
        ?>

<div class="row heading-row">
                <div class="col-12">
                    <h1 class="title text-center">CREDITS LEADERBOARD</h1>
                </div>
            </div>

            <div class="row">
            <?php   

                    $object = new Dbh();
                    $db = $object->connect();
                    $sql = $db->prepare("SELECT username, credits FROM gebruikers ORDER BY credits DESC LIMIT 4");
                    // Execute query
                    $sql->execute();
                    /* Fetch all of the values of the first column */
                    $card_data = $sql->fetchAll();
            
            
                    for ($i = 0; $i < count($card_data); $i++) {
                        $username = strval($card_data[$i][0]);
                        $credits = strval($card_data[$i][1]);
            
                ?>
                        <div class="col-md-3 col-sm-6 margincred">
                            <div class="card text-center card h-100">
                                <div class="card-block h-100">
                                    <!-- Profiel foto -->
                                    <div class="card-title">
                                        <h4><?= $username ?></h4>
                                        <div class="card-text">
                                        <i class="fab fa-bitcoin"></i> <?= $credits ?>
                                        <center><a href="profiel.php?id=<?php echo "$id"; ?>" class="btn btn-success btn-card">Bekijk profiel</a></center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
            }
        ?>
        </div>

</body>
</html>
