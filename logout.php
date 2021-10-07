<?php
  function userlogout()
  {
      if (isset($_POST['logoutsubmit']))
      {
          session_start();
          session_destroy();
          header("Location: login.php");
          exit();
      }
  }
  userlogout();
?>