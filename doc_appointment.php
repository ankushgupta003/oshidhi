<?php
include './connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('Location: doclogin.php');
    exit();
}

// Fetch the doctor's email from the database
$doctor_email = '';
$query = $conn->prepare("SELECT email FROM admins WHERE id = ?");
$query->execute([$admin_id]);

if ($query->rowCount() > 0) {
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $doctor_email = $result['email'];
} else {
    // Handle the case where the doctor's email is not found (optional)
    $doctor_email = 'doctor@example.com';
}



// Fetch appointments for the logged-in doctor
$query = $conn->prepare("SELECT * FROM appointments WHERE doctorEmail = ?");
$query->execute([$doctor_email]);
$appointments = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Appointments</title>
    <link rel="stylesheet" href="./css/docapp.css">
</head>
<body>
    <header>
        <h1>Doctor's Appointments</h1>
        <p>Welcome, <?php echo htmlspecialchars($doctor_email); ?>!</p>
        <form action="doclogin.php" method="post">
            <button type="submit" name="logout">Logout</button>
        </form>
        <button onclick="location.href='doctor_dashboard.php'">Back to Dashboard</button>
    </header>
    <section id="appointments">
        <h2>All Appointments</h2>
        <table>
            <tr>
                <th>Patient Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Reason</th>
                <!-- Add more appointment details as needed -->
            </tr>
            <?php foreach ($appointments as $appointment) { ?>
            <tr>
                <td><?php echo htmlspecialchars($appointment['name']); ?></td>
                <td><?php echo htmlspecialchars($appointment['date']); ?></td>
                <td><?php echo htmlspecialchars($appointment['time']); ?></td>
                <td><?php echo htmlspecialchars($appointment['reason']); ?></td>
                <!-- Add more appointment details as needed -->
            </tr>
            <?php } ?>
        </table>
    </section>
</body>
</html>
