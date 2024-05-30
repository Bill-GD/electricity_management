<?php
if (!isset($_COOKIE['is_logged_in'])) {
  header("Location: /");
  exit;
}
require_once "page_header.php";