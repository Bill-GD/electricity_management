<?php
include_once "../../database.php";
require_once "../../src/helper/helper_methods.php";
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
    if (isset($_POST['email_signup']) && empty($_POST['email_signup'])) {
      echo "<p style='color:red;'>Email cannot be empty</p>";
      exit;
    }
    if (isset($_POST['username_signup']) && empty($_POST['username_signup'])) {
      echo "<p style='color:red;'>Username cannot be empty</p>";
      exit;
    }
    if (isset($_POST['password_signup']) && empty($_POST['password_signup'])) {
      echo "<p style='color:red;'>Password cannot be empty</p>";
      exit;
    }
    if (isset($_POST['password_confirm_signup']) && empty($_POST['password_confirm_signup'])) {
      echo "<p style='color:red;'>You have to confirm the password</p>";
      exit;
    }

    if (isset($_REQUEST["username_signup"])) {
      $email = $_REQUEST["email_signup"];
      $username = $_REQUEST["username_signup"];
      $password = $_REQUEST["password_signup"];
      $password_confirm = $_REQUEST["password_confirm_signup"];

      if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$/", $email)) {
        echo "<p style='color:red;'>Invalid email address.</p>";
        return;
      }
      if (strlen($password) < 4) {
        echo "<p style='color:red;'>Password should have at least 4 characters</p>";
        return;
      }
      if (strlen($password) > 32) {
        echo "<p style='color:red;'>Password should have at most 32 characters</p>";
        return;
      }
      if ($password != $password_confirm) {
        echo "<p style='color:red;'>Password does not match</p>";
        return;
      }

      // if (strlen($password) < 8 || strlen($password) > 20) {
      //   echo "<p style='color:red;'>Password should be between 8 and 20 characters</p>";
      //   return;
      // }
    
      $new_user = new User($email);
      $successful = $new_user->signup($db, $username, $password);

      if (!$successful) {
        echo "<p style='color:red;'>Signup failed</p>";
        exit;
      }

      if (isset($_REQUEST["auto_login"])) {
        $is_logged_in = true;
        setcookie('is_logged_in', $is_logged_in, time() + 3600, '/');
        setcookie('username', $new_user->username, time() + 3600, '/');
        setcookie('user_id', $new_user->user_id, time() + 3600, '/');
        setcookie('email', $new_user->email, time() + 3600, '/');
        setcookie('is_admin', $new_user->type, time() + 3600, '/');

        header("Location: ../../src/main/dashboard.php");
        exit;
      } else {
        header("Location: /");
        exit;
      }
    }
    ?>
  </body>
</html>