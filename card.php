<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial scale=1">
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="CSS/card.css">
    <link rel="stylesheet" href="CSS/explore.css">

</head>

<body>

    <?php
    function display_card()
    {
        $object = new Dbh();
        $db = $object->connect();
        $sql = $db->prepare("SELECT Titel, Beschrijving, Afbeelding, id, likes FROM projecten ORDER BY DATE DESC");
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
                            <img style="max-height: 150px;" src="<?= $thumbnail_url ?>" alt="" class="img-fluid project-image card-img-top">
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
    ?>
</body>

</html>
