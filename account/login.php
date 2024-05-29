<?php
include_once "../database.php";
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
    <br>
    Email <input type="text" name="email_login" >
    <?php if (isset($_POST['email_login']) && empty($_POST['email_login']))
      echo "<p style='color:red;'>Email cannot be empty</p>"; ?>
    <br>
    Password <input type="password" name="password_login" required>
    <?php if (isset($_POST['password_login']) && empty($_POST['password_login']))
      echo "<p style='color:red;'>Password cannot be empty</p>"; ?>
    <br>
    <input type="submit" value="Login">
  </form>
  <?php
  $validDomains = ['gmail.com', '.edu.vn'];
  if (isset($_REQUEST["email_login"])) {
    $email = $_REQUEST["email_login"];
    $password = $_REQUEST["password_login"];

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

    $sql = "SELECT * FROM `User` WHERE email = '{$email}' AND password = '{$password}'";
    $user = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    if (count($user) >= 1) {
      echo "<p style='color:green;'>Login successful</p>";

      $is_logged_in = true;
      setcookie('is_logged_in', $is_logged_in, time() + 3600, '/');
      setcookie('username', $user[0]['username'], time() + 3600, '/');
      setcookie('user_id', $user[0]['user_id'], time() + 3600, '/');
      setcookie('email', $email, time() + 3600, '/');
      setcookie('is_admin', $user[0]['type'], time() + 3600, '/');

      header("Location: ../main/dashboard.php");
    } else {
      echo "<p style='color:red;'>Login failed</p>";
    }
  }
  ?>
</body>

</html>