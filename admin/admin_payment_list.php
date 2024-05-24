<head>
  <link rel="stylesheet" type="text/css" href="../assets/style.css">
</head>

<?php
include_once "../database.php";

$query = "select h.history_id, h.user_id, u.email, u.username, h.pay_date, h.total_cost, h.electricity_usage"
  . " from `History` as h, `User` as u"
  . " where h.user_id = u.user_id"
  ." order by history_id desc";
$result = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>
<div>
  <table>
    <tr>
      <th scope="col">History ID</th>
      <th scope="col">User ID</th>
      <th scope="col">Email</th>
      <th scope="col">Username</th>
      <th scope="col">Pay Date</th>
      <th scope="col">Total Cost</th>
      <th scope="col">Electricity Usage</th>
    </tr>

    <?php
    foreach ($result as $key => $value) { ?>
      <tr>
        <td><?php echo $value["history_id"]; ?></td>
        <td><?php echo $value["user_id"]; ?></td>
        <td><?php echo $value["email"]; ?></td>
        <td><?php echo $value["username"]; ?></td>
        <td><?php echo $value["pay_date"]; ?></td>
        <td><?php echo $value["total_cost"]; ?></td>
        <td><?php echo $value["electricity_usage"]; ?></td>
      </tr>
      <?php
    } ?>
  </table>
</div>