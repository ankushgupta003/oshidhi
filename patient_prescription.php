<?php
include './connect.php';

session_start();

$user_id = $_SESSION['user_id']; // Assuming 'user_id' is stored in session upon patient login

if (!isset($user_id)) {
    header('location:patient_login.php');
    exit();
}

// Fetch the patient's ABHA ID using their email from the users table
$query = $conn->prepare("SELECT abha_id, email FROM users WHERE id = ?");
$query->execute([$user_id]);

if ($query->rowCount() > 0) {
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $abha_id = $result['abha_id'];
    $patient_email = $result['email'];
} else {
    // Handle case where ABHA ID is not found (optional)
    die("ABHA ID not found for the logged-in user.");
}

// Fetch prescriptions for the logged-in patient using their ABHA ID
$query = $conn->prepare("SELECT * FROM prescriptions WHERE abha_id = ?");   

$query->execute([$abha_id]);
$prescriptions = $query->fetchAll(PDO::FETCH_ASSOC);

/// Fetch prescriptions for the logged-in patient using their ABHA ID
$query = $conn->prepare("SELECT * FROM prescriptions WHERE abha_id = ?");
$query->execute([$abha_id]);
$prescriptions = $query->fetchAll(PDO::FETCH_ASSOC);
// Fetch the doctor's name using the doctor_id from the prescriptions
$doctorNames = [];
if (!empty($prescriptions)) {
    $doctorIds = array_unique(array_column($prescriptions, 'doctor_id'));
    if (!empty($doctorIds)) {
        // Generate placeholders for the doctor IDs
        $placeholders = rtrim(str_repeat('?,', count($doctorIds)), ',');
        $sql = "SELECT id, name FROM admins WHERE id IN ($placeholders)";
        $query = $conn->prepare($sql);

        // Bind each doctor ID to its corresponding placeholder
        $index = 1;
        foreach ($doctorIds as $doctorId) {
            $query->bindValue($index++, $doctorId, PDO::PARAM_INT);
        }

        // Execute the query
        if ($query->execute()) {
            $doctors = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach ($doctors as $doctor) {
                $doctorNames[$doctor['id']] = $doctor['name'];
            }
        } else {
            // Handle query execution error
            print_r($query->errorInfo());
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Prescriptions</title>
    <link rel="stylesheet" href="./css/view_prescription.css">
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
<h1> Your Prescriptions </h1>
    <section id="prescriptions">
        <table>
            <tr>
                <th>Doctor Name</th>
                <th>Patient Name</th>
                <th>DOB</th>
                <th>Address</th>
                <th>Abha ID</th>
                <th>Disease</th>
                <th>Medicine Name</th>
                <th>Dosage</th>
                <th>QR Code</th>
            </tr>
            <?php foreach ($prescriptions as $prescription) { ?>
            <tr>
                <td><?= htmlspecialchars($doctorNames[$prescription['doctor_id']] ?? 'Unknown Doctor'); ?></td>
                <td><?= htmlspecialchars($prescription['patient_name']); ?></td>
                <td><?= htmlspecialchars($prescription['dob']); ?></td>
                <td><?= htmlspecialchars($prescription['address']); ?></td>
                <td><?= htmlspecialchars($prescription['abha_id']); ?></td>
                <td><?= htmlspecialchars($prescription['disease']); ?></td>
                <td><?= htmlspecialchars($prescription['medicine_name']); ?></td>
                <td><?= htmlspecialchars($prescription['dosage']); ?></td>
                <td>
                    <?php
                    // Display QR code image
                    echo '<img src="' . htmlspecialchars($prescription['qr_code']) . '" alt="QR Code">';
                    ?>
                </td>
            </tr>
            <?php } ?>
        </table>
    </section>
</body>
</html>
