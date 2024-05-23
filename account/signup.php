<?php
include_once "../database.php";
require_once "../helper/helper_methods.php";
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
      Email <input type="text" name="email_signup" required>
      <br>
      Username <input type="text" name="username_signup" required>
      <br>
      Password <input type="password" name="password_signup" required>
      <br>
      Password Confirm <input type="password" name="password_confirm_signup" required>
      <br>
      Auto Login <input type="checkbox" name="auto_login">
      <br>
      <input type="submit" value="Sign Up">
    </form>
    <?php
    if (isset($_REQUEST["username_signup"])) {
      $email = $_REQUEST["email_signup"];
      $username = $_REQUEST["username_signup"];
      $password = $_REQUEST["password_signup"];
      $password_confirm = $_REQUEST["password_confirm_signup"];

      if (!preg_match("/^[a-zA-Z0-9. _%+-]+@[a-zA-Z0-9. -]+\\.[a-zA-Z]{2,}$/", $email)) {
        echo "Invalid email address.";
        return;
      }
      if ($password != $password_confirm) {
        echo "Password does not match";
        return;
      }

      add_user($email, $username, $password);

      if (isset($_REQUEST["auto_login"])) {
        if (isset($_REQUEST["auto_login"])) {
          $is_logged_in = true;
          setcookie('is_logged_in', $is_logged_in, time() + 3600, '/');
          setcookie('username', $username, time() + 3600, '/');
          setcookie('user_id', $db->lastInsertId(), time() + 3600, '/');
          setcookie('email', $email, time() + 3600, '/');
          setcookie('is_admin', 0, time() + 3600, '/');

          header("Location: ../main/dashboard.php");
          exit;
        }
      }
    }
    ?>
  </body>
</html>