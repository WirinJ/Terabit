<?php
include 'db.inc.php';
session_start();
if (isset($_POST['edit-profile'])) {
    $user = $_SESSION["username"];
    $bio = $_POST['edit-bio'];
    $skills = $_POST['edit-skills'];
    if (!empty($bio)) {
        $object = new Dbh();
        $pdo = $object->connect();
        $sql = "UPDATE `gebruikers` SET `Bio` = ? WHERE username='$user'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$bio]);
    }

    if (!empty($skills)) {
        $object2 = new Dbh();
        $pdo2 = $object2->connect();
        $sql2 = "UPDATE `gebruikers` SET `Skills` = ? WHERE username='$user'";
        $stmt2 = $pdo2->prepare($sql2);
        $stmt2->execute([$skills]);
    }



    $structure = "./users/$user/profilePicture/";
    $folder = "./users/$user/profilePicture";
    $file_name = $_FILES['profiel_foto']['name'];
    if (!empty($file_name)) {
        //header("Location: profiel.php?project-author=$user");
        $file_size = $_FILES['profiel_foto']['size'];
        $file_tmp = $_FILES['profiel_foto']['tmp_name'];
        $file_type = $_FILES['profiel_foto']['type'];
        $file_ext = strtolower(end(explode('.', $file_name)));

        $extensions = array("jpeg", "jpg", "png");



        if (in_array($file_ext, $extensions) === false) {
            $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
        }

        if ($file_size > 2097152) {
            $errors[] = 'File size must be excately 2 MB';
        }




        if (empty($errors) == true) {
            $files = scandir($structure);
            $firstFile = $structure . $files[2]; // because [0] = "." [1] = ".."
            unlink($firstFile);
            rmdir("./users/$user/profilePicture/");
            mkdir($folder, 0777, true);
            move_uploaded_file($file_tmp, "./users/daandorchholz/profilePicture/" . $file_name);
            //header("Location: profiel.php?project-author=$user");
            //exit();
        } else {
            print_r($errors);
        }
    }
    header("Location: profiel.php?project-author=$user");
}
