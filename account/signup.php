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
      Email <input type="text" name="email_signup" required>
      <br>
      Username <input type="text" name="username_signup" required>
      <br>
      Password <input type="password" name="password_signup" required>
      <br>
      Password Confirm <input type="password" name="password_confirm_signup" required>
      <br>
      <input type="submit" value="Login">
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

      $sql = "INSERT into `User` (`email`, `username`, `password`, `type`) values ('{$email}', '{$username}', '{$password}', 0)";
      $user = $db->query($sql);
    }
    ?>
  </body>
</html>