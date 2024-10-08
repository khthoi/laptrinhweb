<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt Upload Form</title>
    <link rel="stylesheet" href="Bai2-styles.css">
</head>

<body>
    <div class="container">
        <form method="POST" action="" enctype="multipart/form-data" onsubmit="return validateForm();">
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
            session_start(); // Start the session

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Save form data in session variables
                $_SESSION['firstName'] = htmlspecialchars($_POST['firstName']);
                $_SESSION['lastName'] = htmlspecialchars($_POST['lastName']);
                $_SESSION['email'] = htmlspecialchars($_POST['email']);
                $_SESSION['invoiceID'] = htmlspecialchars($_POST['invoiceID']);
                $_SESSION['payFor'] = isset($_POST['payFor']) ? $_POST['payFor'] : [];
                $_SESSION['additionalInfo'] = htmlspecialchars($_POST['additionalInfo']);

                // Save form data in cookies (optional, adjust expiration as needed)
                setcookie('firstName', $_SESSION['firstName'], time() + 3600);
                setcookie('lastName', $_SESSION['lastName'], time() + 3600);
                setcookie('email', $_SESSION['email'], time() + 3600);
                setcookie('invoiceID', $_SESSION['invoiceID'], time() + 3600);
                setcookie('payFor', implode(",", $_SESSION['payFor']), time() + 3600);
                setcookie('additionalInfo', $_SESSION['additionalInfo'], time() + 3600);
                // File Upload
                if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] == UPLOAD_ERR_OK) {
                    $targetDir = "uploads2/";
                    if (!file_exists($targetDir)) {
                        mkdir($targetDir, 0777, true); // Create the directory if it doesn't exist
                    }

                    $fileName = basename($_FILES["receipt"]["name"]);
                    $targetFilePath = $targetDir . $fileName;
                    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

                    // Check file size (1MB limit)
                    if ($_FILES["receipt"]["size"] > 1048576) {
                        echo "Sorry, your file is too large.";
                    } elseif (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                        if (move_uploaded_file($_FILES["receipt"]["tmp_name"], $targetFilePath)) {
                            // Display data from session variables
                            echo "<h3>Submitted Information:</h3>";
                            echo "Name: " . $_SESSION['firstName'] . " " . $_SESSION['lastName'] . "<br>";
                            echo "Email: " . $_SESSION['email'] . "<br>";
                            echo "Invoice ID: " . $_SESSION['invoiceID'] . "<br>";
                            echo "Pay For: " . implode(", ", $_SESSION['payFor']) . "<br>";
                            echo "Receipt Uploaded: " . $fileName . "<br>";
                            echo "Additional Information: " . $_SESSION['additionalInfo'] . "<br>";
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
<script src="Bai2-js.js"></script>

</html>