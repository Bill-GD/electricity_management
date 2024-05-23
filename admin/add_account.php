<?php

require_once "../database.php";
require_once "../helper/helper_methods.php";

if (isset($_REQUEST["admin_add_account"])) {
  $email = $_REQUEST["email"];
  $username = $_REQUEST["username"];
  $password = $_REQUEST["password"];
  $type = (int) $_REQUEST["type"];

  if (!preg_match("/^[a-zA-Z0-9. _%+-]+@[a-zA-Z0-9. -]+\\.[a-zA-Z]{2,}$/", $email)) {
    echo "Invalid email address.";
    // header("Location: ../main/dashboard.php");
    // exit;
  }

  add_user($email, $username, $password, $type);
} else {
  echo "No data received";
}
// header("Location: ../main/dashboard.php");