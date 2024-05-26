<?php

include './connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="./css/my_app.css">

</head>
<body>
<header>   
<div class="headers">
    <div class="logos">
        <a href="./index.html"><img src="./images/logo-removebg-preview.png" alt="Logo"></a>
    </div>
    <div class="navbars">
        <a href="#home">Home</a>
        <a href="./appointment.php">Appointments</a>
        <a href="#project">About the project</a>
        <a href="patientlogin.php">Login</a>
    </div>
</div>
</header>

<section class="orders">

   <h1 class="heading">My Appointments</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">Please <a href="patientlogin.php">login</a> to see your history</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `appointments` WHERE user_id = ?");
         $select_orders->execute([$user_id]);

         // Debugging: Output the number of rows fetched
         $count = $select_orders->rowCount();
        
         if($count > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>Name : <span><?= htmlspecialchars($fetch_orders['name']); ?></span></p>
      <p>Date : <span><?= htmlspecialchars($fetch_orders['date']); ?></span></p>
      <p>Time : <span><?= htmlspecialchars($fetch_orders['time']); ?></span></p>
      <p>Number : <span><?= htmlspecialchars($fetch_orders['number']); ?></span></p>
      <p>Doctor : <span><?= htmlspecialchars($fetch_orders['doctor']); ?></span></p>
   </div>
   <?php
            }
         } else {
            echo '<p class="empty">No appointments</p>';
         }
      }
   ?>

   </div>

</section>

</body>
</html>
