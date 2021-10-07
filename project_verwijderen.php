<?php

include 'db.inc.php';
session_start();

if (isset($_SESSION['username'])) {
    $id = $_GET['id'];
    $object = new Dbh();
    $db = $object->connect();

    // Get all the submitted data from the form
    $sql = "DELETE FROM projecten WHERE id=$id";

    // Execute query
    $db->prepare($sql)->execute();
    
    header("Location: explore.php");
    die();
}

?>