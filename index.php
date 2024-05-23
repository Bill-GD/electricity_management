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

    echo "Logged in as: {$username} <br> Email: {$email} <br> User ID: {$user_id} <br> Admin: {$is_admin} <br>";
  } else {
    echo "Not logged in";
  }
} else {
  echo "Not logged in";
}

if ($is_logged_in) { ?>
  <form action="/account/logout.php" method="get">
    <input type="submit" value="Logout">
  </form>
<?php } else {
  ?>
  <form action="/account/login.php" method="get">
    <input type="submit" value="Login">
  </form>
<?php } ?>
<form action="/account/signup.php" method="get">
  <input type="submit" value="Signup">
</form>

<?php
if ($is_logged_in && $is_admin == 1) {
  ?>
  <form action="/admin/manage_account.php" method="get">
    <input type="submit" value="Manage account">
  </form>
<?php } ?>