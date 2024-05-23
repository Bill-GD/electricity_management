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
          var page = $(this).attr('href'); // get the href of the clicked link
          if (page !== "" || !page.includes("logout.php")) { // if the link is not "Home"
            e.preventDefault(); // prevent the default action
            $("#main").load(page); // load the content into <main>
          }
        });
        $(document).on("submit", "form", function (e) {
          e.preventDefault(); // prevent the default action
          $.ajax({
            url: $(this).attr("action"), // get the action attribute of the form
            type: $(this).attr("method"), // get the method attribute of the form
            data: $(this).serialize(), // get the form data
            success: function (response) {
              $("#main").html(response); // load the response into <main>
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
      <ul>
        <li><a href="">Home</a></li>
        <?php if (!$_COOKIE['is_admin']) { ?>
          <li><a href="calculate_electricity_bill.php">Calculate Electricity Bill</a></li>
          <li><a href="payment.php">Payment</a></li>
        <?php } ?>
        <?php if ($_COOKIE['is_admin']) { ?>
          <li><a href="../admin/manage_account.php">Manage Account</a></li>
        <?php } ?>
        <?php if ($_COOKIE['is_logged_in']) { ?>
          <li><a href="../account/logout.php">Log Out</a></li>
        <?php } ?>
      </ul>
    </nav>
    <main id="main"></main>
    <!-- <footer>
      <p>&copy; <?php echo date("Y"); ?> Your Company</p>
    </footer> -->
  </body>

</html>