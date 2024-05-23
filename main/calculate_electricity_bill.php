<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<form method="post" action="calculate_electricity_bill.php">
    <label for="amount">Enter Amount:</label>
    <input type="text" id="amount" name="amount">
    <button type="submit">Calculate</button>
</form>

<?php
function getElectricityCost($kwh_usage) {
    if ($kwh_usage < 0) return -1;

    $stages = [50, 50, 100, 100, 100, 100]; // difference between stages
    $costs = [1678, 1734, 2014, 2536, 2834, 2927];

    $totalCost = 0;

    for ($i = 0; $i < count($stages); $i++) {
        $usage = $stages[$i];

        if ($kwh_usage >= $usage) {
            $totalCost += $usage * $costs[$i];
        } else {
            $totalCost += $kwh_usage * $costs[$i];
            break;
        }

        $kwh_usage -= $usage;
    }

    return $totalCost;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST["amount"];
    if (is_numeric($amount)) {
        $cost = getElectricityCost($amount);
        echo "<p>The electricity cost for $amount kWh is $cost VND</p>";
    } else {
        echo "<p>Please enter a valid number</p>";
    }
}
?>