<head>
  <link rel="stylesheet" type="text/css" href="../assets/style.css">
</head>

<?php
include_once "../database.php";

$query = "select user_id, email, username, `type` from `User` order by user_id desc";
$result = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>
<div>
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
        <td><?php echo $value["type"] === 1 ? 'Admin' : 'User'; ?></td>
        <td>
          <!-- <a href="edit_account.php?id=<?php echo $value["user_id"]; ?>">Edit</a> -->
          <?php if ($value["type"] === 0) { ?>
            <a href="../admin/delete_account.php?user_id=<?php echo $value["user_id"]; ?>">Delete</a>
          <?php } ?>
        </td>
      </tr>
      <?php
    } ?>
  </table>
</div>