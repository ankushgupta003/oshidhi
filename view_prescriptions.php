<?php
include './connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:doclogin.php');
    exit();
}

// Fetch prescriptions for the logged-in doctor
$query = $conn->prepare("SELECT * FROM prescriptions WHERE doctor_id = ?");
$query->execute([$admin_id]);
$prescriptions = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Prescriptions</title>
    <link rel="stylesheet" href="./css/view_prescription.css">
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>
    <header>
        <h1>Prescribed Medicines</h1>
    </header>
    <div id="buttons">
        <button onclick="location.href='prescriptions.php'">Prescribe Medicine</button>
        <button onclick="location.href='view_prescriptions.php'">View Prescriptions</button>
        <button onclick="location.href='doctor_dashboard.php'">Doctor Dashboard</button>
    </div>
    <section id="prescriptions">
        <table>
            <tr>
                <th>Doctor's Name</t>
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
            <td><?= htmlspecialchars($prescription['doctor_name']); ?></td>
                <td><?= htmlspecialchars($prescription['patient_name']); ?></td>
                <td><?= htmlspecialchars($prescription['dob']); ?></td>
                <td><?= htmlspecialchars($prescription['address']); ?></td>
                <td><?= htmlspecialchars($prescription['abha_id']); ?></td>
                <td><?= htmlspecialchars($prescription['disease']); ?></td>
                <td><?= htmlspecialchars($prescription['medicine_name']); ?></td>
                <td><?= htmlspecialchars($prescription['dosage']); ?></td>
                <td>
                    <?php
                    // Generate QR code URL using the API
                    $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($prescription['medicine_name']);
                    // Display QR code image
                    echo '<img src="' . $qrCodeUrl . '" alt="QR Code">';
                    ?>
                </td>
            </tr>
            <?php } ?>
        </table>
    </section>
</body>
</html>
