<?php
include_once "../../database.php";
require_once "../../src/classes/user.php";
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../../assets/style.css">
  </head>

  <body>
    <form method="post">
      <span><a href="/">Back</a></span>
      <br>
      Email <input type="text" name="email_login">
      <br>
      Password <input type="password" name="password_login" required>
      <br>
      <input type="submit" value="Login">
    </form>
    <?php
    if (isset($_POST['email_login']) && empty($_POST['email_login'])) {
      echo "<p style='color:red;'>Email cannot be empty</p>";
      exit;
    }
    if (isset($_POST['password_login']) && empty($_POST['password_login'])) {
      echo "<p style='color:red;'>Password cannot be empty</p>";
      exit;
    }

    if (isset($_REQUEST["email_login"])) {
      $email = $_REQUEST["email_login"];
      $password = $_REQUEST["password_login"];

      $login_user = new User($email);
      $successful = $login_user->login($db, $password);

      if ($successful) {
        echo "<p style='color:green;'>Login successful</p>";

        $is_logged_in = true;
        setcookie('is_logged_in', $is_logged_in, time() + 3600, '/');
        setcookie('username', $login_user->username, time() + 3600, '/');
        setcookie('user_id', $login_user->user_id, time() + 3600, '/');
        setcookie('email', $login_user->email, time() + 3600, '/');
        setcookie('is_admin', $login_user->type, time() + 3600, '/');

        header("Location: ../../src/main/dashboard.php");
      } else {
        echo "<p style='color:red;'>Login failed</p>";
      }
    }
    ?>
  </body>

</html>