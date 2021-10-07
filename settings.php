<?php

include "fnwebsite.php";
include "db.inc.php";

session_start();
$object = new Dbh();
$connect = $object->connect();

?>

<DOCTYPE html>
    <html>

    <head>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="CSS/explore.css">
        <link rel="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    </head>

    <body>
        <?php
        if (isset($_SESSION['username'])) {
            loggedinnavbar();
        } else {
            navbar();
        }

        ?>
        
       <div class="container">
            <div class="row">
                <div class="row justify-content-start heading-row">
                        <div class="col-12">
                            <h1 class="row justify-content-start title text-center">INSTELLINGEN</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-evenly">
                <div class="card" style="width: 83rem; margin-top: 14px;">
                    <div class="card-body">
                        <h5 class="card-title">Wachtwoord wijzigen</h5>
                        <div class="alert alert-primary" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                            </svg>
                            Je wachtwoord moet een minimale lengte van 8 tekens hebben.
                        </div>
                        
                        <form style="margin-bottom: -7px;" class="form-inline"  method="POST" action="wachtwoord-vergeten.php">
                            <div class="form-group mb-2">
                                <label for="inputPassword2" class="sr-only">Nieuw wachtwoord</label>
                                <input type="password" class="form-control" name="wachtwoord" placeholder="Nieuw wachtwoord">
                            </div>
                            <div class="form-group mb-2">
                                <label for="inputPassword2" class="sr-only">Heraal wachtwoord</label>
                                <input type="password" class="form-control" name="wachtwoords" placeholder="Herhaal wachtwoord">
                            </div>
                            <button style="margin-top: 6px;" name="Submit" type="submit" class="btn btn-primary mb-2">Wijzig Wachtwoord</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>