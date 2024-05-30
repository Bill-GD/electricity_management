<?php

if (isset($_REQUEST) && isset($_REQUEST['history_id'])) {
  include_once "../../database.php";

  $history_id = $_REQUEST['history_id'];

  $db->query("DELETE from `History` where history_id = {$history_id}");
  $db->query("CALL reset_history_id()");

  header("Location: admin_payment_list.php");
} else {
  echo "No id received";
}