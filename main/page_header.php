<!DOCTYPE html>
<html>
  <head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../assets/style.css">
  </head>

  <body>
    <header>
      <h1>Electricity Management</h1>
      <h3>Welcome, <?php echo $_COOKIE['username']; ?>!</h3>
    </header>

    <nav>
      <ul id="nav_list">
        <li><a href="page_header.php">Home</a></li>
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