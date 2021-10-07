<?php

include_once 'db.inc.php';
session_start();

$msg = "";

// If upload button is clicked ...
if (isset($_POST['add-project'])) {

  $titel = $_POST["title"];
  $thumbnail = $_FILES["thumbnail"]["name"];
  $tempname = $_FILES["thumbnail"]["tmp_name"];   
  $folder = "ProjectThumbnails/".$thumbnail;
  $description = $_POST["description"];
  $date = date("Y-m-d H:i:s");
  $user = $_SESSION['username'];
  $source = $_POST["source"];
  $milestones = $_POST["milestones"];
  $projects_folder = "./Users/$user/projects/$titel/project-images/";
  if (!file_exists($projects_folder)) {
    mkdir($projects_folder, 0755, true);
  }
  
  $object = new Dbh();
  $db = $object->connect();
  
  // Get all the submitted data from the form
  $sql = "INSERT INTO projecten (Titel, Afbeelding, Beschrijving, User, `date`, Source, Afbeeldingen, Milestones) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

  $files = array_filter($_FILES['project-images']['name']); // Use something similar before processing files.
  // Count the number of uploaded files in array
  $total_count = count($_FILES['project-images']['name']);
  $file_array = $_FILES['project-images']['name'];
  $comma_separated = implode(",", $file_array);
      
  // Count # of uploaded files in array
  $total = count($_FILES['project-images']['name']);

  // Loop through each file
  for( $i=0 ; $i < $total ; $i++ ) {

    //Get the temp file path
    $tmpFilePath = $_FILES['project-images']['tmp_name'][$i];

    //Make sure we have a file path
    if ($tmpFilePath != "") {
      //Setup our new file path
      $newFilePath = "$projects_folder" . $_FILES['project-images']['name'][$i];

      //Upload the file into the temp dir
      move_uploaded_file($tmpFilePath, $newFilePath);
    }
  }

  // Execute query
  $db->prepare($sql)->execute([$titel, $thumbnail, $description, $user, $date, $source, $comma_separated, $milestones]);
  
  // Now let's move the uploaded image into the folder: image
  if (move_uploaded_file($tempname, $folder))  {
      $msg = "Image uploaded successfully";
      if (!file_exists($projects_folder)) {
        mkdir($projects_folder, 0777, true);
      }
  } else  {
    $msg = "Failed to upload image";
  }
  
  header("Location: index.php");
  die();

}


?>