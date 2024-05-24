<?php
require_once "page_header.php";
require_once "../database.php";
require_once "../helper/helper_methods.php";
?>
<style>
  form {
    border: 0;
  }
</style>
<?php
$pay_month = substr(date('Y-m-d', time()), 0, 7);
$query = "select usage_id, user_id, register_date, electricity_usage from `Usage`"
  . " where user_id = {$_COOKIE['user_id']} and register_date like '{$pay_month}%'"
  . " order by usage_id desc";
$result = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);

$registered_usage = 0;
$pay_amount = 0;

if (count($result) > 0) {
  $registered_usage = $result[0]['electricity_usage'];
  $pay_amount = getElectricityCost($registered_usage)[1];
  ?>
  <p>Usage (<?php echo date('M Y', time()) ?>): <?php echo $registered_usage ?></p>
  <p>Cost: <?php echo $pay_amount ?></p>

  <form action="payment.php" method="post">
    <input type="submit" value="Pay" name="pay_submit">
  </form>
<?php } else {
  echo "<p>No usage registered for this month (" . date('M Y', time()) . ") </p>";
}

if (isset($_POST['pay_submit'])) {
  $query = "INSERT INTO `History` (user_id, pay_date, total_cost, electricity_usage) VALUES"
    . " ({$_COOKIE["user_id"]}, '" . date('Y-m-d', time()) . "', {$pay_amount}, {$registered_usage})";
  $db->query($query);

  echo "<p>Payment successful</p>";
}