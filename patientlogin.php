<?php

include './connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   
   $number = $_POST['number'];

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND  number = ?");
   $select_user->execute([$email, $number]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['id'];
      header('location:home.php');
   }else{
      $message[] = 'incorrect username or password!';
   }

}

?>





<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Page</title>
<link rel="stylesheet" type="text/css" href="./css/patient.css">
</head>
<body>

<div class="container">
  
    <form action="" method="post">
      <img class="patientimg" src="./images/man(p).png" alt="Image">
      <h2>Login</h2>
      <div class="input-group">
        <label for="username">Username</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="input-group">
        <label for="password">Password</label>
        <input type="tel" id="number" name="number" required>
      </div>
      <button type="submit" value="submit" name="submit">Login</button>
      <p><b>New Registration?</b> <a href="./patient_register.php">click here</a></p>
      <p><b>Doctor?</b> <a href="./doclogin.php">click here</a></p>
    </form>
  </div>

</body>
</html>
