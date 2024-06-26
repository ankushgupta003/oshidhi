<?php

include './connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

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
        background-color: #F1FADA;
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
        margin-top: 40px;
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
    .content {
        background-color: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        margin-top: 60px;
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
            <a href="index.php">Home</a>
            <a href="#about">Abha</a>
            <a href="#project">About</a>
        </div>
    </div>
</header>

<div class="container">
    <div class="buttons-container">
        <button class="big-button">
           <a href="./doclogin.php"> <img src="./images/doctor.png" alt="Doctor"></a>
            <div class="button-text">DOCTOR</div>
        </button>
        <button class="big-button">
            <a href="./patientlogin.php">  <img src="./images/man(p).png" alt="Patient"></a>
            <div class="button-text">PATIENT</div>
        </button>
    </div>
</div>

<div class="container">
    <div class="content" id="about">
        <img src="./images/ABHA.png" alt="ABHA Image">
        <div>
            <h2>ABHA - Ayushman Bharat Health Account</h2>
            <p>The ABHA card is managed under the Ayushman Bharat Digital Mission (ABDM), which is a digital healthcare initiative of the National Health Authority (NHA). Under this mission, having this health card, the citizens of India are provided with numerous benefits, such as hassle-free access to medical treatments and healthcare facilities, easy sign-up options for personal health record applications (like ABDM ABHA app), and trustable identity.</p>
            <p>It is crucial to remember that the health records associated with Health IDs or ABHA numbers can only be accessed with the informed consent of the individual. People have the option to create an alias, referred to as an "ABHA address" (similar to the email ID xyz@ndhm with a password).</p>
        </div>
    </div>

    <h2 class="team-heading" id="project">About the Project</h2>
    <div class="content">
        <div>
            <p>Our interdisciplinary project aims to seamlessly integrate hardware and software solutions to revolutionize the healthcare sector. At the heart of our innovation is a user-friendly website designed to streamline medical record management using unique Abha IDs. Patients can effortlessly access their previous medical records and prescribed medications, fostering continuity of care and empowering individuals to take control of their health. Additionally, our platform facilitates the prescription process by generating barcodes for newly prescribed medications, ensuring accuracy and efficiency. Complementing our digital infrastructure is a cutting-edge medical ATM powered by Arduino Uno technology. This hardware component autonomously dispenses medications based on the barcode information provided by the website, enhancing accessibility and convenience for patients while optimizing workflow for healthcare providers. Together, our integrated solution represents a significant step forward in leveraging technology to improve healthcare delivery and patient outcomes.</p>
        </div>
    </div>
</div>

</body>
</html>