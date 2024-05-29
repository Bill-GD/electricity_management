<?php
include_once "../database.php";
require_once "../helper/helper_methods.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../assets/style.css">
  </head>
  <body>
    <form method="post">
    <span><a href="/">Back</a></span>
      Email <input type="text" name="email_signup" required>
      <?php if (isset($_POST['email_signup']) && empty($_POST['email_signup'])) echo "<p style='color:red;'>Email cannot be empty</p>"; ?>
      <br>
      Username <input type="text" name="username_signup" required>
      <?php if (isset($_POST['username_signup']) && empty($_POST['username_signup'])) echo "<p style='color:red;'>Username cannot be empty</p>"; ?>
      <br>
      Password <input type="password" name="password_signup" required>
      <?php if (isset($_POST['password_signup']) && empty($_POST['password_signup'])) echo "<p style='color:red;'>Password cannot be empty</p>"; ?>
      <br>
      Password Confirm <input type="password" name="password_confirm_signup" required>
      <?php if (isset($_POST['password_confirm_signup']) && empty($_POST['password_confirm_signup'])) echo "<p style='color:red;'>Password confirmation cannot be empty</p>"; ?>
      <br>
      Auto Login <input type="checkbox" name="auto_login">
      <br>
      <input type="submit" value="Sign Up">
    </form>
    <?php
    $validDomains = ['gmail.com', 'st.phenikaa-uni.edu.vn'];
    if (isset($_REQUEST["username_signup"])) {
      $email = $_REQUEST["email_signup"];
      $username = $_REQUEST["username_signup"];
      $password = $_REQUEST["password_signup"];
      $password_confirm = $_REQUEST["password_confirm_signup"];
  
      $domain = substr(strrchr($email, "@"), 1);
      if (!in_array($domain, $validDomains) && strcmp(substr($domain, -7), '.edu.vn') !== 0) {
        echo "<p style='color:red;'>Invalid email domain. Valid domains are: </p>" . implode(", ", $validDomains);
        return;
      }
  
      if (preg_match('/\s/', $email)) {
        echo "<p style='color:red;'>Email should not contain whitespace</p>";
        return;
      }
  
      if (strlen($password) < 8 || strlen($password) > 255) {
        echo "<p style='color:red;'>Password should be between 8 and 20 characters</p>";
        return;
      }
    

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
        $is_logged_in = true;
        setcookie('is_logged_in', $is_logged_in, time() + 3600, '/');
        setcookie('username', $username, time() + 3600, '/');
        setcookie('user_id', $db->lastInsertId(), time() + 3600, '/');
        setcookie('email', $email, time() + 3600, '/');
        setcookie('is_admin', 0, time() + 3600, '/');

        header("Location: ../main/dashboard.php");
        exit;
      } else {
        header("Location: /");
        exit;
      }
    }
    ?>
  </body>
</html>