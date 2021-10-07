<?php
include 'fnwebsite.php';
include 'fnpost.php';
include 'fncomments.php';
date_default_timezone_set('Europe/Amsterdam');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CSS/login.css">
    <script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
</head>
<body>

<?php

if (isset($_POST['edit-project'])) {
    $sql = "UPDATE `projecten` 
            SET 
                `Beschrijving` = ?, 
                `Source` = ?, 
                `Milestones` = ?
            WHERE `projecten`.`id` = ?";
    $connect->prepare($sql)->execute([$_POST['description'], $_POST['source'], $_POST['milestones'], $_POST['id']]);
    header("Location: project_showcase.php?id=" . $_POST['id']);
}

    loggedinnavbar();
$cid = $_POST["cid"];
$uid = $_POST["uid"];
$date = $_POST["date"];
$message = $_POST["message"];

echo '<center><div class="wrapper">
			<div class="title">
			 Edit</div>
	  <form action="'.editcomments($connect).'" method="POST">
     <div class="ewa">
     <input type="hidden" name="cid" value="' . $cid . '">
     <input type="hidden" name="uid" value="' . $uid . '">
     <input type="hidden" name="date" value="' . $date . '">
     <textarea id="Code" name=message>' . $message . '</textarea required>
     </div>
	  <div class="field">
				<br><input type="submit" name="commentssubmit" value="Edit">
			  </div>
	  </form>
	  </div></center>';

?>

<script>
    CKEDITOR.replace( 'message' );
</script>


</body>
</html>