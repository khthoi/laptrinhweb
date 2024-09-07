<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt Upload Form</title>
    <link rel="stylesheet" href="Bai1-styles.css">
</head>

<body>
    <div class="container">
        <h2>Payment Receipt Upload Form</h2>
        <form method="POST" action="" enctype="multipart/form-data" onsubmit="return validateForm();">
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

            <!-- Payment Receipt Upload Section -->
            <div class="input-group">
                <label for="receipt">Please upload your payment receipt</label>
                <input type="file" id="receipt" name="receipt" accept=".JPG, .JPEG, .PNG, .GIF" required>
                <small>jpg, jpeg, png, gif (1MB max)</small>
            </div>

            <div class="input-group">
                <label for="additionalInfo">Additional Information</label>
                <textarea id="additionalInfo" name="additionalInfo" placeholder="Type here..."></textarea>
            </div>

            <input type="submit" value="Submit">
        </form>
        <div class="submitted-info">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $firstName = htmlspecialchars($_POST['firstName']);
                $lastName = htmlspecialchars($_POST['lastName']);
                $email = htmlspecialchars($_POST['email']);
                $invoiceID = htmlspecialchars($_POST['invoiceID']);
                $payFor = isset($_POST['payFor']) ? implode(", ", $_POST['payFor']) : "None";
                $additionalInfo = htmlspecialchars($_POST['additionalInfo']);

                // File Upload
                if (isset($_FILES['receipt'])) {
                    $targetDir = "uploads/";
                    if (!file_exists($targetDir)) {
                        mkdir($targetDir, 0777, true); // Create the directory if it doesn't exist, with appropriate permissions
                    }

                    $fileName = basename($_FILES["receipt"]["name"]);
                    $targetFilePath = $targetDir . $fileName;
                    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

                    // Check file size (1MB limit)
                    if ($_FILES["receipt"]["size"] > 1048576) {
                        echo "Sorry, your file is too large.";
                    } elseif (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                        if (move_uploaded_file($_FILES["receipt"]["tmp_name"], $targetFilePath)) {
                            echo "<h3>Submitted Information:</h3>";
                            echo "Name: " . $firstName . " " . $lastName . "<br>";
                            echo "Email: " . $email . "<br>";
                            echo "Invoice ID: " . $invoiceID . "<br>";
                            echo "Pay For: " . $payFor . "<br>";
                            echo "Additional Information: " . $additionalInfo . "<br>";
                            echo "Receipt Uploaded: " . $fileName . "<br>";
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }
                    } else {
                        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    }
                }
            }
            ?>
        </div>
    </div>
</body>
<script src="Bai1-js.js"></script>

</html>