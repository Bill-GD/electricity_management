<head>
  <link rel="stylesheet" type="text/css" href="../assets/style.css">
</head>
<?php
include_once "../database.php";
require_once "../helper/helper_methods.php";

$pay_month = substr(date('Y-m-d', time()), 0, 7);
$query = "select usage_id, user_id, register_date, electricity_usage from `Usage`"
  . " where user_id = {$_COOKIE['user_id']} and register_date like '{$pay_month}%'"
  . " order by usage_id desc";
$result = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);

$pay_amount = 0;

if (count($result) > 0) {
  $pay_amount = getElectricityCost($result[0]['electricity_usage'])[1];
  ?>
  <p>Usage (<?php echo date('M Y', time()) ?>): <?php echo $result[0]['electricity_usage'] ?></p>
  <p>Cost: <?php echo $pay_amount ?></p>
<?php } ?>

<form action="payment.php" method="get">
  <input type="submit" value="Submit" name="pay_submit">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pay_submit'])) {
  // include_once "../database.php";

  $pay_date = date('Y-m-d', time());
  $user_id = $_COOKIE["user_id"];

  // print those vars
  // echo "<p>pay_date: $pay_date, user_id: $user_id, amount: {$amount}</p>";
  $sql = "INSERT INTO `History` (user_id, pay_date, total_cost, electricity_usage) VALUES ('{$user_id}', '{$pay_date}', '{$pay_amount}', '{$result[0]['electricity_usage']}')";
  $db->query($sql);

  // echo "Payment successful";
}