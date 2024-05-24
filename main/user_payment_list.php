<?php
require_once "page_header.php";
include_once "../database.php";

$query = "select h.pay_date, h.total_cost, h.electricity_usage"
  . " from `History` as h, `User` as u"
  . " where u.user_id = {$_COOKIE['user_id']} and h.user_id = u.user_id"
  . " order by history_id desc";
$result = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>
<div>
  <table>
    <tr>
      <th scope="col">Pay Date</th>
      <th scope="col">Electricity Usage</th>
      <th scope="col">Total Cost</th>
    </tr>

    <?php
    foreach ($result as $key => $value) { ?>
      <tr>
        <td><?php echo $value["pay_date"]; ?></td>
        <td><?php echo $value["electricity_usage"]; ?></td>
        <td><?php echo $value["total_cost"]; ?></td>
      </tr>
      <?php
    } ?>
  </table>
</div>