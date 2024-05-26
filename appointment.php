<?php

include './connect.php';

session_start();

$message = '';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $doctor = $_POST['doctor'];
    $doctorEmail = $_POST['doctorEmail']; // Retrieve the doctor's email from the hidden input field
    $date = $_POST['date'];
    $time = $_POST['time'];
    $reason = $_POST['reason'];

    // Check if the selected slot is already booked for the selected doctor
    $check_slot = $conn->prepare("SELECT * FROM `appointments` WHERE doctor = ? AND date = ? AND time = ?");
    $check_slot->execute([$doctor, $date, $time]);

    if ($check_slot->rowCount() > 0) {
        $message = 'Slot not available, please check another slot';
    } else {
        $insert_user = $conn->prepare("INSERT INTO `appointments` (user_id, name, email, number, doctor, doctorEmail, date, time,reason) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)");
        $insert_user->execute([$user_id, $name, $email, $number, $doctor, $doctorEmail, $date, $time,$reason]);

        if ($insert_user) {
            $message = 'Appointment booked successfully';
        } else {
            $message = 'Appointment booking failed';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Appointment Booking</title>
    <link rel="stylesheet" href="./css/appstyles.css">
    <link rel="stylesheet" href="./css/header.css">
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
            <a href="patientlogin.php">Login</a>
        </div>
    </div>
</header>

    <main>
        <section id="appointmentForm">
            <?php if (!empty($message)) : ?>
                <p class="message"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="number">Phone Number</label>
                    <input type="number" id="number" name="number" required>
                </div>
                <div class="form-group">
                    <label for="doctor">Choose a Doctor</label>
                    <select id="doctor" name="doctor" required>
                        <option value="">Select</option>
                        <option value="Dr. Abhijeet">Dr. Abhijeet</option>
                        <option value="Dr. Bhavika">Dr. Bhavika</option>
                        <option value="Dr. Shubhan">Dr. Shubhan</option>
                        <option value="Dr. Vinayaka">Dr. Vinayaka</option>
                        <option value="Dr. Ankush">Dr. Ankush</option>
                    </select>
                    <!-- Hidden input field to store the doctor's email -->
                    <input type="hidden" name="doctorEmail" id="doctorEmail" value="">
                </div>
                <div class="form-group">
                    <label for="date">Preferred Date</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="time">Preferred Time</label>
                    <input type="time" id="time" name="time" required>
                </div>
                <div class="form-group">
                    <label for="reason">Resaon for Appointment</label>
                    <input type="text" id="reason" name="reason" required>
                </div>
                <button type="submit" name="submit">Book Appointment</button>
            </form>
        </section>
    </main>
    <script>
        // Script to set the doctor's email in the hidden input field based on the selected doctor
        document.getElementById('doctor').addEventListener('change', function() {
            var doctorEmail = '';
            switch (this.value) {
                case 'Dr. Abhijeet':
                    doctorEmail = 'dr.abhijeet@gmail.com';
                    break;
                case 'Dr. Bhavika':
                    doctorEmail = 'dr.bhavika@gmail.com';
                    break;
                case 'Dr. Shubhan':
                    doctorEmail = 'dr.shubhan@gmail.com';
                    break;
                case 'Dr. Vinayaka':
                    doctorEmail = 'dr.vinayaka@gmail.com';
                    break;
                case 'Dr. Ankush':
                    doctorEmail = 'dr.ankush@gmail.com';
                    break;
                default:
                    doctorEmail = '';
            }
            document.getElementById('doctorEmail').value = doctorEmail;
        });
    </script>
</body>
</html>

