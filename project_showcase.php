<?php

session_start();
include "db.inc.php";
include "fnwebsite.php";
include "fncomments.php";
include "fnpost.php";

$user_posted = $_GET['id'];
$id = $_GET['id'];

$object = new Dbh();
$db = $object->connect();

$sql = $db->prepare("SELECT * FROM projecten WHERE id = ?");
$sql->execute(array($user_posted));
$user_posted = $sql->fetchAll(PDO::FETCH_NUM);
$project_author = $user_posted[0][6];

$query = $db->prepare("SELECT * FROM gebruikers WHERE username = ?");
$query->execute([$project_author]);
$author_info = $query->fetch();
//echo print_r($user_posted);
//die();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    $username = "";
}

$milestones = explode("\n", $user_posted[0][9]);
$project_comment = $user_posted[0][3];
$source = $user_posted[0][5];
$project_title = $user_posted[0][1];
$image_path = "users/$project_author/projects/$project_title/project-images/";
$images_string = $user_posted[0][7];
$image_array = explode(",", "$images_string");


$directory = "users/$project_author/profilePicture/";
$files = scandir ($directory);
$firstFile = $directory . $files[2];// because [0] = "." [1] = ".."

?>

<!doctype html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="JS/comments_likes.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="CSS/project-showcase.css">
    <link rel="stylesheet" href="CSS/explore.css">
    <title>Terabit - <?php echo $project_title ?></title>
</head>

<body>
    <?php 
if (isset($_SESSION['username'])) {
                loggedinnavbar();

        
            } else {
            navbar();
            }
            ?>
        </div>

<div class="container-fluid">
        <div class="row top-row align-items-center">
            <div class="col-2 text-center">
            </div>
            <div class="col-8 black text-center">
                <h1 class="project-title "><?php echo "$project_title"; ?></h1>
            </div>
            <?php if ($username == $project_author) {
                echo '
            <div class="col-1">
            <button data-bs-target="#editProject" data-bs-toggle="modal" type="button" class="btn btn-primary edit float-end"><span class="btn-label"><i class="fa fa-pen"></i></span>Edit
                    </button> 
            </div>
            <div class="col-1">
            <button type="button" class="btn btn-primary delete float-start" data-bs-toggle="modal" data-bs-target="#project-verwijderen"><span class="btn-label"><i class="fa fa-trash"></i></span>Delete
                    </button>
                    </div>';
            } else { 
                echo "
                    <div class='col-2'>
                    <button type='button' class='btn btn-primary delete float-end'><span class='btn-label fa fa-code'></span><a class='source-link' href='" . $source . "'>Source code</a>
                    </button>
                    </div>
                    ";
            }
            ?>
        </div>

        <div class="row second-row">

            <div class="col-8 no-margin carousel slide" id="carouselExampleControls" style="height: 400px;" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php 
                        for ($j = 0; $j < count($image_array); $j++) {
                            $complete_path = $image_path . $image_array[$j];
                            if ($j === 0) {
                                echo '<div class="carousel-item active">
                                    <img height="400" style="object-fit: cover;"class="d-block w-100" src="' . $complete_path .'">
                                </div>';
                            } else {
                                echo '<div class="carousel-item">
                                    <img height="400" style="object-fit: cover;" class="d-block w-100" src="' . $complete_path .'">
                                </div>';
                            }
                        }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <div class="col-4 text-center user-col my-auto">
            
            <div class="d-flex profile-card">
            <div class="image"> <img src="<?php echo $firstFile; ?>" class="rounded-circle profile-picture" width="155" height="155"> </div>
            <div class="ml-3 w-100">
                <h4 class="mb-0 mt-0 username"><a class="username-link" href="profiel.php?project-author=<?php echo "$project_author"; ?>"><?php echo "@$project_author"; ?></a></h4>
                <div class="p-2 mt-2 bg-primary d-flex justify-content-between rounded text-white stats">
                    <div class="d-flex flex-column"> <span class="articles">Projects</span> <span class="number1">38</span> </div>
                    <div class="d-flex flex-column"> <span class="followers">Comments</span> <span class="number2">980</span> </div>
                    <div class="d-flex flex-column"> <span class="rating">Credits</span> <span class="number3"><?php echo $author_info["credits"]; ?></span> </div>
                </div>
                <div class="button mt-2 d-flex flex-row align-items-center">
                <button class="btn btn-sm btn-primary w-100 ml-2 profile-bttn"><a class="profile-link" href="profiel.php?project-author=<?php echo "$project_author"; ?>">Profiel</a> </button> </div>
            </div>
            
        </div>

            </div>
        </div>

        <div class="row row-vh">
            <div class="col-8 text-center comment-col">
                <h3 class="project-h">Project beschrijving:</h3>
                <p style="padding-top: 10px; "class="description"><?php echo $project_comment; ?></p>
            </div>

            <div class="col-4 milestones text-center">
                <h4 class="milestones-title">Development Milestones</h4>
                <ul class="timeline">
                    <?php
                    foreach ($milestones as $milestone) {
                        echo '<li>
                            <p class="milestone-text">' . $milestone . '</p>
                        </li>';
                    }
                    ?>
                </ul>
            </div>
        </div>


    <div class="row empty">
    <div class="col-1"></div>
        <div class="col-10 comment-section">
            <div class="headings d-flex justify-content-between align-items-center mb-3">
                <h5 class="comment-title">Comments</h5>
            </div>
            <div id="commentSection">
                <?php 
                    if (isset($_SESSION['username'])) {
                        comment($connect);
                        sentcomment($connect);
                    } else {
                        comment($connect);
                    }
                ?>
            </div>
        </div>
        <div class="col-1"></div>
        
        
        
    </div>


    <div class="modal fade" id="editProject" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header popup-heading"> 
                    <h5 class="modal-title popup-titel w-100 text-center" id="ModalTitle">Edit project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="edit.php" id="add-project-form" enctype="multipart/form-data">

                    <div class="form-outline mb-4">
                    <div class="form-outline mb-4">
                </div>

                <label>Project titel</label>
                <input type="text" name='title' placeholder="Project titel" id="title" value='<?= $project_title; ?>' class="form-control input-shadow" disabled>
            </div>

            <div class="form-outline mb-4">
                <label>Project beschrijving</label>
                <textarea type="text" name='description' class="w-100 mb-40 input-shadow" placeholder="<?= $project_comment; ?>" id="description" rows="10" required><?= $project_comment; ?></textarea><br>
            </div>

            <div class="form-outline mb-4">
                <label>Milestones</label>
                <textarea type="text" name='milestones' class="w-100 mb-40 input-shadow" id="milestones" value='' rows="10" required><?php foreach ($milestones as $milestone) {
                        echo $milestone;
                    } ?></textarea>
            </div>

            <div class="form-outline mb-4">
                <label>Source code</label>
                <input type="text" name='source' id="source" value='<?= $source ?>' class="form-control input-shadow" />
            </div>

            <input type="hidden" id="custId" name="id" value="<?= $id ?>">

            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
            <button type="submit" name="edit-project" form="add-project-form" value="add-project" class="btn btn-primary">Bijwerken</button>
        </div>
    </div>


    <div class="modal fade" id="project-verwijderen" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalTitle">Weet je het zeker?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="project_verwijderen.php?id=<?php echo "$id"; ?>" id="delete-project-form">
                        <div class="group">
                            <h6>Dit kan niet ongedaan gemaakt worden!</h6>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                    <button type="submit" name="delete-project" form="delete-project-form" value="delete-project" class="btn btn-primary">Project verwijderen</button>
                </div>
                </form>
            </div>
        </div>

    </div>
    </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>


</html>