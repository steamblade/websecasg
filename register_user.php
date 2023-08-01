
<?php
require_once 'register.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check the honeypot field
    if (!empty($_POST['honeypot'])) {
        // This is likely a bot submission, reject it
        header("Location: captcha_error.html");
        exit;
    }

    // Validate CAPTCHA and email format
    if (isset($_POST['captcha']) && $_POST['captcha'] == $_SESSION['captcha'] && filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)) {
        $email = $_POST["Email"];
        $password = $_POST["password"];

        // Insert the user data into the database
        if (registerUser($email, $password)) {
            echo "Registration successful!";
        } else {
            echo "Error: Registration failed!";
        }
    } else {
        // Redirect to the CAPTCHA error page
        header("Location: captcha_error.html");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 5px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            text-align: center;
            font-size: 18px;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #bb0471;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registration Successful!</h1>
        <p>Welcome to the protected area.</p>
        <!-- Your other content here -->
        <div class="back-link">
            <a href="index.html">Back to Login</a>
        </div>
    </div>
</body>
</html>
