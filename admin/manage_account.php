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

<!-- form to add account: email, username, password, type -->
<form method="post" name="admin_add_account">
  <label>Add Account</label>
  Email <input type="text" name="email" required>
  <br>
  Username <input type="text" name="username" required>
  <br>
  Password <input type="password" name="password" required>
  <br>
  Admin <input type="checkbox" name="type">
  <br>
  <input type="submit" value="Add">
</form>

<?php
if (isset($_REQUEST["email"])) {
  $email = $_REQUEST["email"];
  $username = $_REQUEST["username"];
  $password = $_REQUEST["password"];
  $type = $_REQUEST["type"] === 'on' ? '1' : '0';

  header("Location: ../admin/add_account.php?admin_add_account=1&email=$email&username=$username&password=$password&type=$type");
}