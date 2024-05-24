<?php
if (!isset($_COOKIE['is_logged_in'])) {
  header("Location: /");
  exit;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../assets/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      $(document).ready(function () {
        $("nav a").click(function (e) {
          let page = $(this).attr('href');
          if (page === "" || page.includes("logout.php")) return;

          e.preventDefault();
          $("#main").load(page);
        });
        $(document).on("submit", "form", function (e) {
          if (page != "payment.php") {
            e.preventDefault();
          }
          $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            data: $(this).serialize(),
            success: function (response) {
              $("#main").html(response);
            }
          });
        });
      });
    </script>
  </head>

  <body>
    <header>
      <h1>Electricity Management</h1>
      <h3>Welcome, <?php echo $_COOKIE['username']; ?>!</h3>
    </header>

    <nav>
      <ul id="nav_list">
        <li><a href="">Home</a></li>
        <?php if (!$_COOKIE['is_admin']) { ?>
          <li><a href="calculate_electricity_bill.php">Calculate Electricity Bill</a></li>
          <li><a href="payment.php">Payment</a></li>
          <li><a href="user_payment_list.php">History</a></li>
        <?php } else { ?>
          <li><a href="../admin/manage_account.php">Manage Account</a></li>
          <li><a href="../admin/admin_payment_list.php">Payment List</a></li>
        <?php } ?>
        <?php if ($_COOKIE['is_logged_in']) { ?>
          <li><a href="../account/logout.php">Log Out</a></li>
        <?php } ?>
      </ul>
    </nav>
    <main id="main"></main>
  </body>

</html>