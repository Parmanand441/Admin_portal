<?php
session_start();
include("conn.php");

if (isset($_POST['submit'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encrypt password

    // Handle profile picture upload
    $profile_img = "uploads/default-avatar.png"; // Default profile image
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file_name = time() . "_" . basename($_FILES["file"]["name"]);
        $target_dir = "uploads/";
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $profile_img = $target_file;
        }
    }

    // Insert user data into database
    $sql = "INSERT INTO students (fname, lname, email, password, profile_img) 
            VALUES ('$fname', '$lname', '$email', '$password', '$profile_img')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['user_id'] = mysqli_insert_id($conn);
        $_SESSION['fname'] = $fname;
        $_SESSION['lname'] = $lname;
        $_SESSION['profile_img'] = $profile_img;

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
