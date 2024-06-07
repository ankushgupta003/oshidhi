<?php

include './connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
} else {
   header('location:patientlogin.php');
   exit();
}

// Fetch the patient's name from the database
$query = $conn->prepare("SELECT name FROM users WHERE id = ?");
$query->execute([$user_id]);
$patient_name = '';
if ($query->rowCount() > 0) {
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $patient_name = $result['name'];
} else {
    // Handle case where the patient's name is not found (optional)
    $patient_name = 'Patient';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome !</title>
    <link rel="stylesheet" type="text/css" href="./css/home.css">
    <link rel="stylesheet" type="text/css" href="./css/header.css">
</head>
<body>
<header>   
    <div class="headers">
        <div class="logos">
            <a href="./index.html"><img src="./images/logo-removebg-preview.png" alt="Logo"></a>
        </div>
        <div class="navbars">
            <a href="./home.php">Home</a>
            <a href="./appointment.php">Appointments</a>
            <a href="./patient_prescription.php">Prescriptions</a>
            <a href="patientlogin.php">Logout</a>
        </div>
    </div>
</header>
<main class="backgrounds">
    <div class="welcome-message">
        <h2>Welcome, <?= htmlspecialchars($patient_name); ?>!</h2>
    </div>
    <div class="containers">
    <div class="buttons-container">
        <button class="big-button">
           <a href="./appointment.php"> <img src="./images/appointment.gif" alt="Doctor"></a>
            <div class="button-text">Book Your Appointment</div>
        </button>
        <button class="big-button">
            <a href="./my_app.php">  <img src="./images/my_appointments.gif" alt="Patient"></a>
            <div class="button-text">My Appointments</div>
        </button>
        <button class="big-button">
            <a href="./patient_prescription.php">  <img src="./images/medicine.gif" alt="Patient"></a>
            <div class="button-text">View Medications</div>
        </button>
    </div>
</div>
    </div>

    <div class="feedback-container">
        <h2>Patient Feedback Form</h2>
        <form action="https://script.google.com/macros/s/AKfycbzvSywPiycpP-FWuhdOGMwGyLmf62j7dsbgL1Jg8g4gC9by_pxCnmn-4dOsC2TtR93j/exec" method="post" name="feedback">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="7" required></textarea>
            </div>
            <button type="submit" name="submit">Submit Feedback</button>
        </form>
    </div>
</main>
<script src="./js/form.js"></script>
</body>
</html>
