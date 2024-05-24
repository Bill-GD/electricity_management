<link rel="stylesheet" type="text/css" href="../assets/style.css">
<style>
  body {
    margin-top: 20px;
  }

  div {
    display: flex;
    max-width: fit-content;
    text-align: center;
  }

  form {
    border: 0;
  }
</style>
<?php
$user_id = -1;
$username = '';
$email = '';
$is_admin = 0;
$is_logged_in = false;

if (isset($_COOKIE['is_logged_in'])) {
  $is_logged_in = $_COOKIE['is_logged_in'];
  if ($is_logged_in) {
    $user_id = $_COOKIE['user_id'];
    $username = $_COOKIE['username'];
    $email = $_COOKIE['email'];
    $is_admin = $_COOKIE['is_admin'];

    header("Location: main/dashboard.php");
    exit;
  }
} else {
  echo "<p>Not logged in</p>";
}
?>

<div>
  <form action="/account/login.php" method="get">
    <input type="submit" value="Login">
  </form>
  <form action="/account/signup.php" method="get">
    <input type="submit" value="Signup">
  </form>
</div>

<?php
if ($is_logged_in && $is_admin == 1) {
  ?>
  <form action="/admin/manage_account.php" method="get">
    <input type="submit" value="Manage account">
  </form>
<?php } ?>