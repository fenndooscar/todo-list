<!DOCTYPE html>
<html lang="ru" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>My To-Do list</title>
  </head>
  <body>
    <?php
      if (!isset($_SESSION['username'])) {
      	$_SESSION['msg'] = "You must log in first";
      	header('location: ../registration/login.php');
      } else {
        header('location: ../todo/index.php');
      }
      if (isset($_GET['logout'])) {
      	session_destroy();
      	unset($_SESSION['username']);
      	header("location: ../registration/login.php");
      }
    ?>
  </body>
</html>
