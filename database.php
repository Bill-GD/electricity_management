<?php
include_once "config.php";

$uri = "mysql://{$aiven_username}:{$aiven_password}@mysql-issue-tracker-dc87b75-issue-tracking-app.h.aivencloud.com:13387/issue_tracker_db?ssl-mode=REQUIRED";

$fields = parse_url($uri);

// build the DSN including SSL settings
$conn = "mysql:";
$conn .= "host=" . $fields["host"];
$conn .= ";port=" . $fields["port"];
$conn .= ";dbname=elec_manage";
$conn .= ";sslmode=verify-ca;sslrootcert=ca.pem";

try {
  global $db;
  $db = new PDO($conn, $fields["user"], $fields["pass"]);
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}