<?php

if (isset($_REQUEST) && isset($_REQUEST['user_id'])) {
  include_once "../database.php";

  $user_id = $_REQUEST['user_id'];

  $db->query("CALL delete_user({$user_id})");

  header("Location: ../main/dashboard.php");
} else {
  echo "No id received";
}