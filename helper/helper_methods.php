<?php

require_once "../database.php";

function add_user(string $email, string $username, string $password, int $type = 0): void {
  global $db;

  $db->query("INSERT into `User` (`email`, `username`, `password`, `type`) values ('{$email}', '{$username}', '{$password}', $type)");
}