<?php
session_start();
include './connect.php';
require 'vendor/autoload.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $fname = $_POST['fname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $aadhar = $_POST['aadhar'];
    $enumber = $_POST['enumber'];
    $abha_id = $_POST['abha_id'];
    $history = $_POST['history'];

    // Generate a 6-digit OTP
    $otp = rand(100000, 999999);
    
    // Save user data and OTP in session
    $_SESSION['otp'] = $otp;
    $_SESSION['user_data'] = [
        'name' => $name,
        'fname' => $fname,
        'dob' => $dob,
        'gender' => $gender,
        'email' => $email,
        'number' => $number,
        'address' => $address,
        'aadhar' => $aadhar,
        'enumber' => $enumber,
        'abha_id' => $abha_id,
        'history' => $history
    ];

    // Send OTP to user's email
    sendOtpEmail($email, $otp);

    // Redirect to OTP verification page
    header("Location: verify_otp.php");
    exit();
}

function sendOtpEmail($toEmail, $otp) {
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'oshidhi.g61@gmail.com';
        $mail->Password = 'bandrulifmkcsacq';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        
        $mail->setFrom('oshidhi.g61@gmail.com', 'Oshidhi');
        $mail->addAddress($toEmail);
        
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = "Your OTP code is <b>$otp</b>";
        
        $mail->send();
        echo 'OTP has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patient Registration</title>
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #F1FADA;
    }
    .container {
        max-width: 500px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
        color: #265073;
    }
    form {
        display: grid;
        gap: 20px;
    }
    label {
        font-weight: bold;
    }
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="number"],
    select,
    textarea {
        width: calc(100% - 20px);
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    input[type="file"] {
        width: 100%;
        padding: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    input[type="submit"] {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: #265073;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    input[type="submit"]:hover {
        background-color: #2D9596;
    }
    .error-message {
        color: #dc3545;
        font-size: 14px;
        margin-top: -10px;
        margin-bottom: 10px;
    }
</style>
</head>
<body>
<div class="container">
    <h2>Patient Registration</h2>
    <form action="" method="post">
        <label for="fullname">Full Name:*</label>
        <input type="text" id="fullname" name="name" required>

        <label for="fathername">Father's Name:*</label>
        <input type="text" id="fathername" name="fname" required>

        <label for="dob">Date of Birth:*</label>
        <input type="date" id="dob" name="dob" required>

        <label for="gender">Gender:*</label>
        <select id="gender" name="gender" required>
            <option value="">Select</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>

        <label for="email">Email Address:*</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Phone Number:*</label>
        <input type="tel" id="phone" name="number" pattern="[0-9]{10}" required>

        <label for="address">Address:*</label>
        <input type="text" id="address" name="address" required>

        <label for="aadhar">Aadhar Number:*</label>
        <input type="number" id="aadhar" name="aadhar" required>

        <label for="enumber">Emergency Contact Number:*</label>
        <input type="tel" id="enumber" name="enumber" pattern="[0-9]{10}" required>

        <label for="abha_id">Abha ID:*</label>
        <input type="text" id="abha_id" name="abha_id" required>
        <span class="error-message">* If you don't have an aabha ID, please <a href="https://www.eka.care/ayushman-bharat/create-aabha-abdm-ndhm-health-id?utm_source=Paid&utm_medium=SEM&utm_campaign=Health-ID&utm_term=KWs&gad_source=1&gclid=CjwKCAjwi_exBhA8EiwA_kU1Ms8pNRICqRsJpJgW_SGnKTZuMQof83YPHoDd9IDUAf9OTIFSiaBOtRoCU6oQAvD_BwE">click here</a>.</span>

        <label for="history">Previous Medical History:*</label>
        <textarea id="history" name="history" rows="5" required></textarea>

        <input type="submit" value="Register" name="submit">
        <p>Already have an account ?</p>
        <a href="patientlogin.php">Login Now !</a>
    </form>
</div>
</body>
</html>
