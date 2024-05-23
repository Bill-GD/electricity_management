<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $("nav a").click(function (e) {
                var page = $(this).attr('href'); // get the href of the clicked link
                if (page !== "") { // if the link is not "Home"
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
        <h1>Welcome to the Electricity management</h1>
    </header>

    <nav>
        <ul>
            <li><a href="">Home</a></li>
            <li><a href="calculate_electricity_bill.php">Calculate Electricity Bill</a></li>
            <li><a href="payment.php">Payment</a></li>
        </ul>
    </nav>

    <main id="main">


    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Your Company</p>
    </footer>
</body>

</html>