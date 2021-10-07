<?php
include "db.inc.php";
include "fnwebsite.php";
include "card.php";
session_start();
$profile_name = $_GET['project-author'];
if (isset($_SESSION['username'])) {
    $current_user = $_SESSION['username'];
} else {
    $current_user = "";
}
$object = new Dbh();
$db = $object->connect();
$sql = $db->prepare("SELECT userID, username FROM gebruikers WHERE username='$profile_name'");
// Execute query
$sql->execute();
/* Fetch all of the values of the first column */
$profile_data = $sql->fetchAll();

$directory = "users/$profile_name/profilePicture/";
$files = scandir($directory);
$firstFile = $directory . $files[2]; // because [0] = "." [1] = ".."

//print_r($profile_data) . "\n";
//echo $profile_data[0][0] . "\n";
//echo $profile_data[0][1] . "\n";




function display_profile_card($profile_name)
{
    $object = new Dbh();
    $db = $object->connect();
    $sql = $db->prepare("SELECT Titel, Beschrijving, Afbeelding, id, likes, User FROM projecten WHERE User='$profile_name' ORDER BY DATE DESC");
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

?>
        <div class="col-md-4 col-sm-6">
            <div class="card text-center card h-100">
                <div class="card-block h-100">
                    <img style="max-height: 150px; height: 150px;" src="<?= $thumbnail_url ?>" alt="" class="img-fluid project-image card-img-top">
                    <div class="card-title">
                        <h4><?= $titel ?></h4>
                        <div class="card-text">
                            <center><a href="project_showcase.php?id=<?php echo "$id"; ?>" class="btn btn-success btn-card">Bekijk project</a></center>
                            <i class="far fa-heart e-icon"></i> <?= $likes ?>
                            <?php
                            $connect = new PDO("mysql:host=localhost;dbname=terabit", "root", "");
                            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $statement = $connect->prepare("SELECT COUNT(`message`) FROM comments WHERE post_id = $id");
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
}

function displayBio($profile_name)
{
    $object = new Dbh();
    $db = $object->connect();
    $sql = $db->prepare("SELECT Bio FROM gebruikers WHERE username='$profile_name'");
    // Execute query
    $sql->execute();
    $bio_array = $sql->fetchAll();
    $bio = strval($bio_array[0][0]);
    echo "$bio";
}

function display_skills($profile_name)
{
    $object = new Dbh();
    $db = $object->connect();
    $sql = $db->prepare("SELECT Skills FROM gebruikers WHERE username='$profile_name'");
    // Execute query
    $sql->execute();
    $skills_array = $sql->fetchAll();
    $skills = strval($skills_array[0][0]);
    $skillstr = explode("\n", $skills);


    foreach ($skillstr as $skill) {
        $skill_separated = explode(" ", $skill);
        $skill_name = $skill_separated[0];
        $skill_percentage = $skill_separated[1];


        echo '
        <h4 class="skill-name">' . $skill_name . '</h4>
        <div class="progress progress-c" style="height: 20px;">
  <div class="progress-bar bg-info" role="progressbar" style="width: ' . $skill_percentage . '" aria-valuenow="' . $skill_percentage . '" aria-valuemin="0" aria-valuemax="100"></div>
</div>
        
        ';
    }
}

function edit_skills($profile_name)
{
    $object = new Dbh();
    $db = $object->connect();
    $sql = $db->prepare("SELECT Skills FROM gebruikers WHERE username='$profile_name'");
    // Execute query
    $sql->execute();
    $skills_array = $sql->fetchAll();
    $skills = strval($skills_array[0][0]);
    $skillstr = explode("\n", $skills);


    foreach ($skillstr as $skill) {
        echo $skill;
    }
}


function displayComments($profile_name)
{


    $object = new Dbh();
    $db = $object->connect();
    $sql = $db->prepare("SELECT * FROM comments WHERE uid='$profile_name'");
    // Execute query
    $sql->execute();
    $count = $sql->rowCount();
    echo "Comments: $count";
    
}

function displayProjecten($profile_name)
{


    $object = new Dbh();
    $db = $object->connect();
    $sql = $db->prepare("SELECT * FROM projecten WHERE User='$profile_name'");
    // Execute query
    $sql->execute();
    $count = $sql->rowCount();
    echo "Projecten: $count";
    
}

function displayCredits($profile_name)
{

    $object = new Dbh();
    $db = $object->connect();
    $sql = $db->prepare("SELECT credits FROM gebruikers WHERE username='$profile_name'");
    // Execute query
    $sql->execute();
    $credit_array = $sql->fetchAll();
    $credits = strval($credit_array[0][0]);
    echo "Credits: $credits";
    
}

?>







<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <link rel="stylesheet" href="Css/profiel.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">

<body>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    <?php
    if (isset($_SESSION['username'])) {
        loggedinnavbar();
    } else {
        navbar();
    }
    ?>


    <div class="container emp-profile">

        <div class="row first-row">
            <?php
            if ($current_user == $profile_name) {
            ?>
                <div class="col-md-6">
                    <div class="profile-img">
                        <img src="<?php echo $firstFile; ?>" alt="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="profile-head">
                        <h4 class="name">
                            <?php echo "@$profile_name"; ?>
                        </h4>
                        <p class="info">
                            <?php
                        displayComments($profile_name);
                        ?>
                        </p>
                        <p class="info">
                        <?php    
                        displayProjecten($profile_name);
                        ?>
                        </p>
                        <p class="info">
                            <?php
                        displayCredits($profile_name);
                        ?>
                        </p>


                    </div>

                </div>
                <div class="col-md-2">
                    <button type="button" class="btn edit-profile" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Profiel bewerken
                    </button>
                </div>
            <?php
            } else {
            ?>
                <div class="col-md-1">

                </div>
                <div class="col-md-6">
                    <div class="profile-img">
                        <img src="<?php echo $firstFile; ?>" alt="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="profile-head">
                        <h4 class="name">
                            <?php echo "@$profile_name"; ?>
                        </h4>
                        <p class="info">
                            <?php
                        displayComments($profile_name);
                        ?>
                        </p>
                        <p class="info">
                        <?php    
                        displayProjecten($profile_name);
                        ?>
                        </p>
                        <p class="info">
                            <?php
                        displayCredits($profile_name);
                        ?>
                        </p>

                    </div>
                </div>
                <div class="col-md-1">

                </div>


            <?php
            }
            ?>



            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="edit-profiel-heading" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-profiel-heading">Profiel bewerken</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="profiel_foto.php" id="edit-profile-form" enctype="multipart/form-data">

                                <div class="form-outline mb-4">
                                    <label for="profiel_foto">Selecteer profiel foto</label><br>
                                    <input type="file" name="profiel_foto" id="profiel_foto">
                                </div><br>

                                <div class="form-outline mb-4">
                                    <label for="edit-bio">Bio</label><br>
                                    <textarea name="edit-bio" id="edit-bio-id" class="w-100 mb-40 input-shadow bio-modal" rows="10" placeholder=""><?php displayBio($profile_name); ?></textarea>
                                </div><br>

                                <div class="form-outline mb-4">
                                    <label for="edit-skills">Skills</label><br>
                                    <p>Vul de naam van je skill in gevold door het percentage dat je deze skill beheerst.
                                    Scheidt meerdere skills met enter. Bijvoorbeeld:<br>
                                    Php 80%<br>
                                    javascript 50%

                                    </p>
                                    <textarea name="edit-skills" id="edit-skills-id" class="w-100 mb-40 input-shadow bio-modal" rows="10" placeholder=""><?php edit_skills($profile_name); ?></textarea>
                                </div><br>








                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                            <button type="submit" name="edit-profile" form="edit-profile-form" value="submit" class="btn btn-primary">Wijzigingen opslaan</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-md-6 text-center">
                <h2 class="projecten-heading">PROJECTEN</h2>
                <div class="row">
                    <?php
                    display_profile_card($profile_name);
                    ?>
                </div>
            </div>
            <div class="col-1">

            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-12 bio-h text-center">
                        <h2 class="bio-heading">BIO</h2>
                        <p class="bio"><?php displayBio($profile_name); ?></p>
                    </div>
                    <div class="col-12 bio-h text-center">
                        <h2 class="bio-heading">Skills</h2>
                        <?php
                        display_skills($profile_name);
                        ?>
                    </div>

                </div>
        </div>
    </div>
    </div>
    </div>
    </div>
</body>

</html>
