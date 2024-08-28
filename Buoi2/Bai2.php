<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt Upload Form</title>
    <link rel="stylesheet" href="Bai2-styles.css">
</head>
<body>
    <form method="POST" action="" onsubmit="return validateForm();">
        <h2>Payment Receipt Upload Form</h2>
        <div id="errorMessages"></div>

        <div class="input-group">
            <label for="firstName">Name</label>
            <input type="text" id="firstName" name="firstName" placeholder="First Name">
        </div>

        <div class="input-group">
            <input type="text" id="lastName" name="lastName" placeholder="Last Name">
        </div>

        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="example@example.com">
        </div>

        <div class="input-group">
            <label for="invoiceID">Invoice ID</label>
            <input type="text" id="invoiceID" name="invoiceID">
        </div>

        <div class="checkbox-group">
            <label>Pay For</label><br>
            <label><input type="checkbox" name="payFor[]" value="15K Category"> 15K Category</label>
            <label><input type="checkbox" name="payFor[]" value="35K Category"> 35K Category</label>
            <label><input type="checkbox" name="payFor[]" value="55K Category"> 55K Category</label><br>
            <label><input type="checkbox" name="payFor[]" value="75K Category"> 75K Category</label>
            <label><input type="checkbox" name="payFor[]" value="116K Category"> 116K Category</label>
            <label><input type="checkbox" name="payFor[]" value="Shuttle One Way"> Shuttle One Way</label><br>
            <label><input type="checkbox" name="payFor[]" value="Shuttle Two Ways"> Shuttle Two Ways</label>
            <label><input type="checkbox" name="payFor[]" value="Compressport T-Shirt Merchandise"> Compressport T-Shirt Merchandise</label>
            <label><input type="checkbox" name="payFor[]" value="Buf Merchandise"> Buf Merchandise</label>
        </div>

        <input type="submit" value="Submit">
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo "<div class='submitted-info'>";
            $firstName = htmlspecialchars($_POST['firstName']);
            $lastName = htmlspecialchars($_POST['lastName']);
            $email = htmlspecialchars($_POST['email']);
            $invoiceID = htmlspecialchars($_POST['invoiceID']);
            $payFor = isset($_POST['payFor']) ? implode(", ", $_POST['payFor']) : "None";

            echo "<h3>Submitted Information:</h3>";
            echo "Name: " . $firstName . " " . $lastName . "<br>";
            echo "Email: " . $email . "<br>";
            echo "Invoice ID: " . $invoiceID . "<br>";
            echo "Pay For: " . $payFor . "<br>";
            echo "</div>";
        }
        ?>
</body>
<script src="Bai2-js.js"></script>
</html>
