<head>
  <link rel="stylesheet" type="text/css" href="../assets/style.css">
</head>

<form method="post" action="calculate_electricity_bill.php">
  <label for="amount">Enter Amount:</label>
  <input type="number" id="amount" name="amount">
  <br><br>
  <button type="submit">Calculate</button>
</form>

<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $amount = $_POST["amount"];
  if (is_numeric($amount)) {
    $cost = getElectricityCost($amount);
    echo "<p>The electricity cost for $amount kWh is {$cost[0]} VND</p>";
    echo "<p>The cost after tax (10%) is {$cost[1]} VND</p>";
  } else {
    echo "<p>Please enter a valid number</p>";
  }
}
?>