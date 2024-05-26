<?php
require_once './vendor/autoload.php';
include './connect.php';

use Endroid\QrCode\QrCode;

session_start();
$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:doclogin.php');
    exit();
}

// Fetch the doctor's name from the database
$doctor_name = '';
$query = $conn->prepare("SELECT name FROM admins WHERE id = ?");
$query->execute([$admin_id]);

if ($query->rowCount() > 0) {
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $doctor_name = $result['name'];
} else {
    $doctor_name = 'Doctor';
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_name = $_POST['patient_name'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $abha_id = $_POST['abha_id'];
    $disease = $_POST['disease'];
    $medicines = $_POST['medicines'];

    // Prepare statement for inserting prescription
    $stmtPrescription = $conn->prepare("INSERT INTO prescriptions (doctor_id, doctor_name, patient_name, dob, address, abha_id, disease, medicine_name, dosage, qr_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($medicines as $medicine) {
        $med_name = $medicine['name'];
        $med_dosage = $medicine['dosage'];

        // Generate QR code URL
        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode("$med_name");

        // Insert into database
        $stmtPrescription->execute([$admin_id, $doctor_name, $patient_name, $dob, $address, $abha_id, $disease, $med_name, $med_dosage, $qrCodeUrl]);
    }

    echo "<script>alert('Prescription added successfully');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Dashboard - Prescribe Medicine</title>
    <link rel="stylesheet" href="./css/prescription.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($doctor_name); ?></h1>
    </header>
    <section id="prescription">
        <h2>Prescribe Medicine</h2>
        <form method="POST">
            <div class="form-group">
                <label for="patient_name">Patient Name</label>
                <input type="text" id="patient_name" name="patient_name" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" required></textarea>
            </div>
            <div class="form-group">
                <label for="abha_id">Abha ID</label>
                <input type="text" id="abha_id" name="abha_id" required>
            </div>
            <div class="form-group">
                <label for="disease">Disease</label>
                <input type="text" id="disease" name="disease" required>
            </div>
            <div id="medicine-container">
                <div class="form-group medicine-group">
                    <label for="medicine_name">Medicine Name</label>
                    <input type="text" name="medicines[0][name]" required>
                    <label for="medicine_dosage">Dosage</label>
                    <input type="text" name="medicines[0][dosage]" placeholder="e.g., 1 tablet twice a day for 7 days" required>
                </div>
            </div>
            <div class="buttons">
                <button type="button" id="add-medicine">Add Another Medicine</button>
                <button type="submit">Prescribe</button>
                <button type="button" onclick="location.href='view_prescriptions.php'">View Prescribed Medicines</button>
            </div>
        </form>
    </section>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("DOM content loaded");

        const addMedicineBtn = document.getElementById("add-medicine");
        const medicineContainer = document.getElementById("medicine-container");

        addMedicineBtn.addEventListener("click", function () {
            const index = medicineContainer.querySelectorAll(".medicine-group").length;
            const newMedicineGroup = document.createElement("div");
            newMedicineGroup.classList.add("form-group", "medicine-group");
            newMedicineGroup.innerHTML = `
                <label for="medicine_name">Medicine Name</label>
                <input type="text" name="medicines[${index}][name]" required>
                <label for="medicine_dosage">Dosage</label>
                <input type="text" name="medicines[${index}][dosage]" placeholder="e.g., 1 tablet twice a day for 7 days" required>
            `;
            medicineContainer.appendChild(newMedicineGroup);
        });
    });
    </script>
</body>
</html>
