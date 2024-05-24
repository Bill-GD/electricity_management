<?php
require_once "page_header.php";
?>

<form method="post" action="calculate_electricity_bill.php">
  <label for="amount">Enter Amount:</label>
  <input type="number" id="amount" name="amount">
  <br><br>
  <button type="submit">Calculate</button>
</form>

<?php
require_once "../helper/helper_methods.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["amount"])) {
  $amount = $_POST["amount"];
  if (is_numeric($amount) && $amount >= 0) {
    $cost = getElectricityCost($amount);
    echo "<p>The electricity cost for $amount kWh is {$cost[0]} VND</p>";
    echo "<p>The cost after tax (10%) is {$cost[1]} VND</p>";
  } else {
    echo "<p>Please enter a valid number</p>";
  }
}
?>

<form method="post" action="calculate_electricity_bill.php">
  <h3>Update Electricity Usage (Total usage in a month)</h3>
  <label>Current month: <?php echo date('M Y', time()) ?></label>
  <label for="amount">Enter Amount:</label>
  <input type="number" id="amount" name="usage_amount">
  <br><br>
  <button type="submit">Register</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["usage_amount"])) {
  include_once "../database.php";

  $usage_amount = $_POST["usage_amount"];
  if (!is_numeric($usage_amount) || $usage_amount < 0) {
    echo "<p>Please enter a valid number</p>";
    exit;
  }

  if ($usage_amount > 0) {
    echo "<p>Registered $usage_amount kWh</p>";

    // find if there is a record for today
    $query = "SELECT * FROM `Usage` WHERE user_id = {$_COOKIE['user_id']} AND register_date = '" . date('Y-m-d', time()) . "'";
    $result = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) <= 0) {
      $query = "INSERT INTO `Usage` (user_id, register_date, electricity_usage) VALUES ({$_COOKIE['user_id']}, '" . date('Y-m-d', time()) . "', $usage_amount)";
    } else {
      $query = "UPDATE `Usage` SET electricity_usage = $usage_amount WHERE user_id = {$_COOKIE['user_id']} AND register_date like '" . date('Y-m', time()) . "%'";
    }
    $db->query($query);
  } else {
    $query = "DELETE FROM `Usage` WHERE user_id = {$_COOKIE['user_id']} AND register_date like '" . date('Y-m', time()) . "%'";
    $db->query($query);
  }
}