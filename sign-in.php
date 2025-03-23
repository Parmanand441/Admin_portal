<?php
   include ("conn.php");
   session_start();
   if(!empty($_POST)){
if(!empty($_POST['email']) && !empty($_POST['password']) ){

     $email= $_POST['email'];
    $password= $_POST['password'];
   $sql ="select * from students where  email ='$email' AND password='$password'";
   $record=  mysqli_query($conn,$sql);
    if(mysqli_num_rows($record)>0){
        $logindata= mysqli_fetch_assoc($record);
        print_r($logindata);
        echo "Login successfully";
        $_SESSION['id']=$logindata['id'];
        $_SESSION['name']=$logindata['fname'].' '.$logindata['lname'];
        $_SESSION['email']=$logindata['email'];
        $_SESSION['login']=true;
        header('location:dashboard.php');
    }
    else {
        echo "something went to wrong";
    }
}
else {
    echo "Email and password both are required..";
}
   }
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud Application</title>
    <!-- Bootstrap CSS CDN link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <!-- <h1 class ="container-fluid text-center bg-success text-light f-10 p-3">User Registeration</h1> -->
<div class="container mt-5">
<form action="sign-in.php" method="POST">
        <div class="form-group mb-3">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>
        <div class="form-group mb-3">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <div class="form-group">
            <a href="sign-up.php" class="btn btn-success text-uppercase">Sign Up</a>
            <button type="submit" class="btn btn-link bg-success text-light text-decoration-none text-uppercase">Login</button>
        </div>
    </form>

    <!-- Bootstrap JS and Popper.js CDN links -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
