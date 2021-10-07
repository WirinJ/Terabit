<?php

function post($connect) {
    $query = "SELECT * FROM projecten LIMIT 10";
    $i = 0;
    $statement = $connect->query($query);
    foreach ($statement as $eerste)
    {
        $i++;
        echo '<center>
       
        <div><h1><a href=showpost.php?id=' . $i . '>' . $eerste["Titel"] . '</a></h1></div>
        <div><h1><a href=showpost.php?id=' . $i . '>' . $eerste["Afbeelding"] . '</a></h1></div>
        <div><h1><a href=showpost.php?id=' . $i . '>' . $eerste["Beschrijving"] . '</a></h1></div>
        <div><h1><a href=showpost.php?id=' . $i . '>' . $eerste["date"] . '</a></h1></div>
        <div><h1><a href=showpost.php?id=' . $i . '>' . $eerste["User"] . '</a></h1></div>
        </form>
        </center></div>
        ';
      
    }
}

function zoekpost($connect) {
    if (isset($_POST['zoeken']))
    {

        $filter = $_POST['zoeken'];
        $query = "SELECT * FROM projecten WHERE User LIKE '%$filter%'";
        $i = 0;
        $statement = $connect->query($query);
        foreach ($statement as $eerste)
        {
            $i++;
            echo '<center>
                
                 <div><h1><a href=showpost.php?id=' . $i . '>' . $eerste["Titel"] . '</a></h1></div>
                 <div><h1><a href=showpost.php?id=' . $i . '>' . $eerste["Beschrijving"] . '</a></h1></div>
                 <div><h1><a href=showpost.php?id=' . $i . '>' . $eerste["User"] . '</a></h1></div>
                 <div><h1><a href=showpost.php?id=' . $i . '>' . $eerste["date"] . '</a></h1></div>
                 </form>
                 </center></div>';
        }

    }
}
function showpost($connect) {
    $statement = $connect->prepare("SELECT * FROM `projecten` WHERE id = :id");
    $id = $_GET['id'];
    $statement->execute(array(
        ':id' => $id
    ));
    foreach ($statement as $eerste)
    {
        $statement2 = $connect->prepare("SELECT * FROM `projecten` WHERE id = :id");
        $id =  $_GET['id'];
        $statement2->execute(array(
            ':id' => $id
        ));
        if ($eerste2 = $statement2->fetch())
        {
            $statement3 = $connect->prepare("SELECT COUNT(`comid`) FROM  likes WHERE comid = :id AND type = 'projecten' ");
            $id = $eerste["id"];
            $type = 'projecten';
            $statement3->execute(array(
               ':id'    => $id
             ));
             if($eerste3 = $statement3->fetch()) {
            echo '<center><div><h1>' . $eerste["Titel"] . '</h1>
     <h2>Omschrijving: </h2> <div class="omschrijf"><h2 class="floatleft">' . $eerste["Beschrijving"] . '</h2></div>
     <h2>Youtube-link :</h2> 
     <object type="application/x-shockwave-flash"><param name="src" value="http://www.youtube.com/v/' . $eerste["Video"] . '" /></object>
     <h2>Like : '. $eerste3["COUNT(`comid`)"] .'</h2>
     <h2>Datum : ' . $eerste["date"] . '</h2>
     <h2>User : ' . $eerste["User"] . '</h2></center>';
            if (isset($_SESSION['username']))
            {
                    $user = $_SESSION["username"];
                        echo '<center><form action="' .postlike($connect). '" method="POST">
                       <div class="postlike"><a href="likes.php"><button name="postlike" value="" class="fa fa-thumbs-up"></a></button></div>
                        <input type="hidden" name="id" value="' . $eerste["id"] . '">
                        <input type="hidden" name="uid" value="'.$user.'">
                             </form><br><br><br><form action="' .postdislike($connect). '" method="POST">
                             <div class="postdislike"><a href="likes.php"><button name="postdislike"class="fa fa-thumbs-down"></button></a></div>
                              <input type="hidden" name="id" value="' . $eerste["id"] . '">
                              <input type="hidden" name="uid" value="'.$user.'">
                             
                               </form></center>';
                    
            }
        }
    }
    }
  }
?>