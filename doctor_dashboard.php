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

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Oshidhi</title>
<link rel="icon" href="./images/title logo.png" type="image/icon type">
<link rel="stylesheet" type="text/css" href="./css/header.css">

<style>
    body {
        margin: 0;
        font-family: 'Roboto', sans-serif;
        background-image: url("images/background.png");
        color: #333;
        line-height: 1.6;
    }
    .container {
        padding: 40px 20px;
        max-width: 1200px;
        margin: 0 auto;
    }
    .buttons-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin-top: 1rem;
    }
    .big-button {
        flex: 1 1 250px;
        max-width: 300px;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        background-color: whitesmoke;
        text-align: center;
    }
    .big-button:hover {
        transform: translateY(-5px);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
        background-color: white;
    }
    .big-button img {
        width: 100%;
        height: auto;
    }
    .button-text {
        padding: 20px 0;
        font-size: 18px;
        font-weight: 600;
        background-color: #265073;
        color: white;
    }
    h1{
        text-align: center;
    }
    .content {
        background-color: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        margin-top: 1rem;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
    }
    .content img {
        max-width: 100%;
        height: auto;
        margin-bottom: 20px;
    }
    .content > div {
        flex: 1;
        padding-left: 0;
    }
    .content h2 {
        font-size: 30px;
        margin-top: 0;
    }
    .content p {
        font-size: 16px;
        margin-bottom: 10px;
    }
    @media screen and (min-width: 768px) {
        .big-button {
            flex: 1 1 300px;
        }
        .content img {
            max-width: 400px;
            margin-right: 20px;
        }
        .content > div {
            padding-left: 20px;
        }
    }
    .team-heading {
        text-align: center;
        font-size: 30px;
        margin-top: 60px;
    }
    .circle-images {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    .circle-images img {
        border-radius: 50%;
        margin: 10px;
        width: 100px;
        height: 100px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    }

</style>
</head>
<body>

<header>   
    <div class="headers">
        <div class="logos">
            <a href="./index.html"><img src="./images/logo-removebg-preview.png" alt="Logo"></a>
        </div>
        <div class="navbars">
            <a href="./doclogin.php">Logout</a>
        </div>
    </div>
</header>
        <h1>Welcome, <?= htmlspecialchars($doctor_name); ?>!</h1>

<div class="container">
    <div class="buttons-container">
        <button class="big-button">
           <a href="./doc_appointment.php"> <img src="./images/appointment.gif" alt="Doctor"></a>
            <div class="button-text">Appointments</div>
        </button>
        <button class="big-button">
            <a href="./prescriptions.php">  <img src="./images/new_prescription.gif" alt="Patient"></a>
            <div class="button-text">New Prescription</div>
        </button>
        <button class="big-button">
            <a href="./view_prescriptions.php">  <img src="./images/prescription.gif" alt="Patient"></a>
            <div class="button-text">View Prescriptions</div>
        </button>
    </div>
</div>

<div class="container">
    <div class="content">
        <div>
        <h2 class="team-heading" id="project">About <?php echo htmlspecialchars($doctor_name); ?></h2>
        <ul>
        <li>Education : </li>
            <ul>
            <li>M.D. from Harvard Medical School</li>
            <li>Residency in Internal Medicine at Massachusetts General Hospital</li>
            <li>Fellowship in Cardiology at the Cleveland Clinic</li>
            </ul>
        <li>Certifications :</li>
        <ul>
            <li>Board certified in Internal Medicine and Cardiovascular Disease</li>
            </ul>
        <li>Experience : </li>
        <ul>
            <li>15+ years in diagnosing and treating cardiovascular conditions</li>
            <li>Expertise in interventional cardiology, including angioplasty and stent placement</li>
            </ul>
        <li>Research and Publications : </li>
        <ul>
            <li>Published 50+ peer-reviewed articles on heart disease and cardiac imaging</li>
            <li>Principal investigator in clinical trials on innovative heart treatments</li>
            </ul>
        <li>Patient Care : </li>
        <ul>
            <li>Known for compassionate care and personalized treatment plans</li>
            <li>Advocate for preventive cardiology and patient education</li>
            </ul>    
        </ul>
        </div>
    </div>
</div>

</body>
</html>