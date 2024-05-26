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
	<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-6QKD96WWVK"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-6QKD96WWVK');
</script>
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9364449639098581"
     crossorigin="anonymous"></script>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   

<section class="orders">

   <h1 class="heading">Your History</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">please <a href="patientlogin.php">login</a> to see your history</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `appointments` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">

      <p>name : <span><?= $fetch_orders['name']; ?></span></p>
      <p>email : <span><?= $fetch_orders['email']; ?></span></p>
      <p>number : <span><?= $fetch_orders['number']; ?></span></p>
      <p>Date : <span><?= $fetch_orders['date']; ?></span></p>
  </div>
   <?php
      }
      }else{
         echo '<p class="empty">no Medical History yet yet!</p>';
      }
      }
   ?>

   </div>

</section>


</body>
</html>