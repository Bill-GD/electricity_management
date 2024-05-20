<?php
include_once "../database.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Document</title>
  </head>
  <body>
    <form method="post">
      Username <input type="text" name="username_login" required>
      <br>
      Password <input type="password" name="password_login" required>
      <br>
      <input type="submit" value="Login">
    </form>
    <?php
    if (isset($_REQUEST["username_login"])) {
      $username = $_REQUEST["username_login"];
      $password = $_REQUEST["password_login"];

      $sql = "SELECT * FROM `User` WHERE username = '{$username}' AND password = '{$password}'";
      $user = $db->query($sql)->fetchAll();
      if (count($user) >= 1) {
        echo "Login successful";
      } else {
        echo "Login failed";
      }
    }
    ?>
  </body>
</html>