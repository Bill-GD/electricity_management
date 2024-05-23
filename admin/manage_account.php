<?php
include_once "../database.php";

$query = "select user_id, email, username, `type` from `User`";
$result = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>
<table>
  <tr>
    <th scope="col">User ID</th>
    <th scope="col">Email</th>
    <th scope="col">Username</th>
    <th scope="col">Type</th>
    <th scope="col">Action</th>
  </tr>

  <?php
  foreach ($result as $key => $value) { ?>
    <tr>
      <td><?php echo $value["user_id"]; ?></td>
      <td><?php echo $value["email"]; ?></td>
      <td><?php echo $value["username"]; ?></td>
      <td><?php echo $value["type"]; ?></td>
      <td>
        <!-- <a href="edit_account.php?id=<?php echo $value["user_id"]; ?>">Edit</a> -->
        <a href="delete_account.php?user_id=<?php echo $value["user_id"]; ?>">Delete</a>
      </td>
    </tr>
    <?php
  } ?>

</table>