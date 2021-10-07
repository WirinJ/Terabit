<?php

include "likes.php";
include_once 'db.inc.php';
$object = new Dbh();
$connect = $object->connect();

if (isset($_POST['commentsubmit'])) {
    $id = $_POST["post_id"];
    $uid = $_POST['uid'];
    $date = $_POST['date'];
    $message = $_POST['commenst'];
    $sql = "INSERT INTO `comments` (`uid`, `date`, `message`, `post_id`) VALUES (:uid, :date, :message, :post_id) LIMIT 1";
    $sql_run = $connect->prepare($sql);
    $exe = $sql_run->execute(array(":uid" => $uid, ":date" => $date, ":message" => $message, ":post_id" => $id)); 
    die();
}

function comment($connect)
{
    $qu = $connect->prepare("SELECT * FROM  comments WHERE post_id = :id");
    $id = $_GET['id'];
    $qu->execute(array(
        ':id' => $id
    ));
    while ($eerste = $qu->fetch())
    {
        $qu2 = $connect->prepare("SELECT * FROM  gebruikers WHERE username = :id");
        $id = $eerste["uid"];
        $qu2->execute(array(
            ':id' => $id
        ));
        if ($eerste2 = $qu2->fetch())
        {
            $qu3 = $connect->prepare("SELECT COUNT(`comid`) FROM  likes WHERE comid = :id AND type = 'comments' ");
            $id = $eerste["cid"];
            $type = 'commenst';
            $qu3->execute(array(
                ':id' => $id
            ));
            if ($eerste3 = $qu3->fetch())
            {
                if (isset($_SESSION['username']))
                {
                    $user_map = $eerste2['username'];
                    $map_path = "users/$user_map/profilePicture/";
                    $files = scandir($map_path);
                    $profile_picture = $map_path . $files[2]; 
                    echo '<div class="card p-3 mt-2 single-comment">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="user d-flex flex-row align-items-center"> 
                                        <img src="' . $profile_picture .'" width="60" height="60" class="user-img rounded-circle mr-2">
                                        <span>
                                            <small class="font-weight-bold text-primary">' . $eerste["uid"] . '</small>
                                            <small class="font-weight-bold">' . $eerste['message'] . '</small>
                                        </span>
                                    </div>
                                    <small>' . $eerste["date"] . '</small>
                                </div>
                        <!--</div>-->
                            <div class="action d-flex justify-content-between mt-2 align-items-center"><!--</div>-->
                    ';
                    
                    $user = $_SESSION["username"];

                    if ($_SESSION['username'] == $eerste2['username'])
                    {
                        echo ' <form  action="' . deletecomments($connect) . '" method="POST">
                            <div class="reply px-4"> <button class="btn btn-danger delete-button btn-sm" type="submit" name="Delete">Delete</button>   <input type="hidden" name="cid" value="' . $eerste["cid"] . '">
                        </form>';
                    }

                    if ($_SESSION['username'] == $eerste2['username'])
                    {
                        echo '<form action="edit.php" method="POST">
                            <button class="btn btn-success edit-button btn-sm" name="edit">Edit</button>
                            <input type="hidden" name="cid" value="' . $eerste["cid"] . '">
                            <input type="hidden" name="uid" value="' . $eerste["uid"] . '">
                            <input type="hidden" name="date" value="' . $eerste["date"] . '">
                            <input type="hidden" name="message" value="' . $eerste["message"] . '">
                        </form>';
                    }
                    echo '
                        </div><form action="' . like($connect) . '" method="POST">
                        <div class="icons align-items-center"><p>' . $eerste3["COUNT(`comid`)"] . '</p><button name="like" class="fa fa-heart like" value=""></button></i>
                        <input type="hidden" name="cid" value="' . $eerste["cid"] . '">
                        <input type="hidden" name="uid" value="' . $user . '"></div>
                        </form>
                        </div>
                    </div>';      

                } else {
                    echo '<div class="card p-3 mt-2 single-comment">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="user d-flex flex-row align-items-center"> 
                                    <img src="https://i.imgur.com/hczKIze.jpg" width="30" class="user-img rounded-circle mr-2">
                                    <span>
                                        <small class="font-weight-bold text-primary">' . $eerste["uid"] . '</small>
                                        <small class="font-weight-bold">' . $eerste['message'] . '</small>
                                    </span>
                                </div>
                                <small>' . $eerste["date"] . '</small>
                            </div>
                        </div>
                    <div class="action d-flex justify-content-between mt-2 align-items-center"></div>';
                }
            }
        }
    }
}

if (isset($_POST['refresh'])) {
    comment($connect);
    sentcomment($connect);
}

function sentcomment($connect) { 
     echo ' <br><br><center>
     <input type="hidden" id="comment_user" name="uid" value=' . $_SESSION['username']. '>
     <input type="hidden" id="comment_id" name="post_id" value="' . $_GET['id'] . '">
     <input type="hidden" id="comment_date" name="date" value="' .date("Y-m-d H:i:s"). '">
     <fieldset style="width: 1810;" > 
             <div class="form-group col-xs-12 col-sm-9 col-lg-10">
                 <textarea rows="5" style="margin: auto; width: 70%;" class="form-control" name="commenst" id="comment_message" placeholder="Your message" required=""></textarea>
                 <br><br><button style="margin: auto; width: 22%;" onclick="doComment();" class="btn btn-dark">Comment</button>
             </div> 	
     </fieldset>
    </center>';
}

function editcomments($connect) {
    if (isset($_POST['commentssubmit'])) {
        $cid = $_POST['cid'];
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];
        $sql = "UPDATE comments SET message='$message' WHERE cid='$cid'";
        $result = $connect->query($sql);
        echo "<script>history.go(-2);</script>";
    }
}

function deletecomments($connect) {
    if (isset($_POST['Delete'])) {
        $_POST["post_id"] = $_GET["id"];
        $id = $_POST["post_id"];
        $cid = $_POST['cid'];
        $sql = "DELETE FROM comments WHERE cid='$cid'";
        $result = $connect->query($sql);
    }
}

deletecomments($connect);

?>