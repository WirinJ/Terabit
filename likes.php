<?php

include_once 'db.inc.php';
$object = new Dbh();
$connect = $object->connect();


function like($connect) {
    if (isset($_POST["like"])) {
     
        $_POST["post_id"] = $_GET["id"];
        $ids = $_POST["post_id"];
        $id = $_POST["like"];
        $cid = $_POST["cid"];
        $user = $_POST["uid"];
        $type = "comments";
        $search = "SELECT * FROM likes WHERE user='".$user."' AND comid='".$cid."' AND type='".$type."'"; 
        $stmt = $connect->prepare($search);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row == 0) {
         $sql1 = "INSERT INTO `likes` (`user`, `comid`, `type`)
        SELECT * FROM (SELECT '$user', '$cid', '$type') AS tmp
        WHERE NOT EXISTS (
            SELECT user, comid, type FROM `likes` WHERE user = '$user' AND comid = '$cid' AND type = '$type'
        ) LIMIT 1;";
        $sql_run = $connect->prepare($sql1);
        $exe = $sql_run->execute(array());

        if ($exe) {
            $sql2 = "UPDATE `comments` SET `likes` = '1' WHERE `comments`.`cid` = '$cid'";
            $run = $connect->query($sql2);
            if ($run) {
                $sql3 = "UPDATE `gebruikers` SET `credits` = credits + 1 WHERE `gebruikers`.`username` = '$user';";
                $run1 = $connect->query($sql3);
                $sql4 = "UPDATE `projecten` SET `likes` = likes + 1 WHERE `projecten`.`id` = '$ids';";
                $run2 = $connect->query($sql4);
            }
        }
    } 
    }
    }

    function postlike($connect) {
        if (isset($_POST["postlike"])) {
         
            
            $id = 1;
            $user = $_POST["uid"];
            $type = "projecten";
             $sql1 = "INSERT INTO `likes` (`user`, `comid`, `type`)
            SELECT * FROM (SELECT '$user', '$id', '$type') AS tmp
            WHERE NOT EXISTS (
                SELECT user, comid, type  FROM `likes` WHERE user = '$user' AND comid = '$id' AND type = '$type'
            ) LIMIT 1;";
            $sql_run = $connect->prepare($sql1);
            $exe = $sql_run->execute(
            );
    
            if ($exe) {
                $sql2 = "UPDATE `projecten` SET `likes` = '1' WHERE `projecten`.`id` = '$id'";
                $run = $connect->query($sql2);
            }
      
        }
    }
    
  postlike($connect);

  like($connect);





?>
