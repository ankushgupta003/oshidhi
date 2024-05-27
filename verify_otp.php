<?php
session_start();
include './connect.php';

if (isset($_POST['verify'])) {
    $otp = $_POST['otp'];
    
    if ($otp == $_SESSION['otp']) {
        // OTP is correct, insert user data into the database
        $userData = $_SESSION['user_data'];
        
        $insert_user = $conn->prepare("INSERT INTO `users`(name, fname, dob, gender, email, number, address, aadhar, enumber, aabha, history) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_user->execute([
            $userData['name'], $userData['fname'], $userData['dob'], $userData['gender'],
            $userData['email'], $userData['number'], $userData['address'], $userData['aadhar'],
            $userData['enumber'], $userData['aabha'], $userData['history']
        ]);

        // Clear session data
        unset($_SESSION['otp']);
        unset($_SESSION['user_data']);

        // Show success message and redirect to login page
        echo "<script>
                alert('Patient registered successfully!');
                window.location.href='patientlogin.php';
              </script>";
        exit();
    } else {
        echo 'Invalid OTP. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verify OTP</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-image: url("images/background.png");
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
        box-sizing: border-box;
    }

    h2 {
        margin-top: 0;
        text-align: center;
        color: #333;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    label {
        margin-bottom: 10px;
        font-weight: bold;
        color: #555;
    }

    input[type="text"] {
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    input[type="submit"] {
        background-color: #265073;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    input[type="submit"]:hover {
        background-color: #2D9596;
        color: white;
    }
</style>
</head>
<body>
<div class="container">
    <h2>Verify OTP</h2>
    <form action="verify_otp.php" method="post">
        <label for="otp">Enter OTP:</label>
        <input type="text" id="otp" name="otp" required>
        <input type="submit" value="Verify" name="verify">
    </form>
</div>
</body>
</html>
