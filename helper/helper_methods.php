<?php

require_once dirname(__DIR__) . "\database.php";

function add_user(string $email, string $username, string $password, int $type = 0): void {
  global $db;

  try {
    $db->query("INSERT into `User` (`email`, `username`, `password`, `type`) values ('{$email}', '{$username}', '{$password}', $type)");
  } catch (PDOException $e) {
    echo "<p>Error: " . explode('for', explode('1062', $e->getMessage())[1])[0] . "</p>";
  }
}

function getElectricityCost(int $kwh_usage) {
  if ($kwh_usage < 0)
    return [-1, -1];

  $stages = [50, 50, 100, 100, 100, 100]; // difference between stages
  $costs = [1678, 1734, 2014, 2536, 2834, 2927];

  $totalCost = 0;

  for ($i = 0; $i < count($stages); $i++) {
    $usage = $stages[$i];

    if ($kwh_usage >= $usage) {
      $totalCost += $usage * $costs[$i];
    } else {
      $totalCost += $kwh_usage * $costs[$i];
    }

    $kwh_usage -= $usage;
    if ($kwh_usage <= 0)
      break;
  }
  if ($kwh_usage > 0) {
    $totalCost += $kwh_usage * $costs[count($stages) - 1];
  }

  return [$totalCost, round($totalCost * 1.1)];
}