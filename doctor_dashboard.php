<?php
include './connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
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
    // Handle the case where the doctor's name is not found (optional)
    $doctor_name = 'Doctor';
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: doclogin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Dashboard</title>
    <link rel="stylesheet" href="./css/Dr.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($doctor_name); ?></h1>
        <form action="" method="post">
            <button type="submit" name="logout">Logout</button>
        </form>
    </header>
    <section id="qualification">
        <h2>Qualification</h2>
        <p><?php echo htmlspecialchars($doctor_name); ?> has a Doctor of Medicine (MD) degree from XYZ University.</p>
        <!-- Add more qualification details as needed -->
    </section>
    <section id="about">
        <h2>About</h2>
        <p><?php echo htmlspecialchars($doctor_name); ?> is a dedicated medical professional with expertise in...</p>
        <!-- Add more details about the doctor -->
    </section>
    <section id="buttons">
        <button onclick="location.href='prescriptions.php'">Prescriptions</button>
        <button onclick="location.href='doc_appointment.php'">Appointments</button>
    </section>
</body>
</html>
