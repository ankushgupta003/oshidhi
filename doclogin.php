<?php



include './connect.php';



session_start();



if(isset($_POST['submit'])){



   $email = $_POST['email'];
   $pass = sha1($_POST['password']);



   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE email = ? AND password = ?");

   $select_admin->execute([$email, $pass]);

   $row = $select_admin->fetch(PDO::FETCH_ASSOC);



   if($select_admin->rowCount() > 0){

      $_SESSION['admin_id'] = $row['id'];

      header('location: doctor_dashboard.php');

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
<title>Login</title>
<link rel="stylesheet" href="./css/doc.css">
</head>
<body>
 
  <div class="container">
    <img class="docimg" src="./images/doctor.png">
    <h2>Login</h2>
    <form action="" method="post">
      <div class="input-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="email" required>
      </div>
      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit" name="submit">Login</button>
      <p><b>Are you a patient?</b> <a href="./patientlogin.php">click here</a></p>
    </form>
  </div>
</body>
</html>
