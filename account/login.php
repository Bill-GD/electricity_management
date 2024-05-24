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
    <a href="/">Back</a>
    <form method="post">
      Email <input type="text" name="email_login" required>
      <br>
      Password <input type="password" name="password_login" required>
      <br>
      <input type="submit" value="Login">
    </form>
    <?php
    if (isset($_REQUEST["email_login"])) {
      $email = $_REQUEST["email_login"];
      $password = $_REQUEST["password_login"];

      $sql = "SELECT * FROM `User` WHERE email = '{$email}' AND password = '{$password}'";
      $user = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
      if (count($user) >= 1) {
        echo "Login successful";

        $is_logged_in = true;
        setcookie('is_logged_in', $is_logged_in, time() + 3600, '/');
        setcookie('username', $user[0]['username'], time() + 3600, '/');
        setcookie('user_id', $user[0]['user_id'], time() + 3600, '/');
        setcookie('email', $email, time() + 3600, '/');
        setcookie('is_admin', $user[0]['type'], time() + 3600, '/');

        header("Location: ../main/dashboard.php");
      } else {
        echo "Login failed";
      }
    }
    ?>
  </body>
</html>