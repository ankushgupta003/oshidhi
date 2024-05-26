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
    /* Your CSS styles */
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
