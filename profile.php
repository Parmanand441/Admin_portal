<?php 
session_start();
include 'conn.php'; // Include database connection

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $error_message = "You are not logged in. Please log in to view your profile.";
    $user_id = null; // Prevent SQL errors
} else {
    $user_id = $_SESSION['user_id'];
}

$fname = $lname = $email = "";
$profile_img = "images/default-avatar.png"; // Default profile image

// ✅ Check if 'profile_img' column exists
$profile_img_exists = false;
$check_profile_img_sql = "SHOW COLUMNS FROM students LIKE 'profile_img'";
$check_result = mysqli_query($conn, $check_profile_img_sql);
if (mysqli_num_rows($check_result) > 0) {
    $profile_img_exists = true;
}

// ✅ Fetch user data only if logged in
if ($user_id !== null) {
    $sql = "SELECT fname, lname, email";
    if ($profile_img_exists) {
        $sql .= ", profile_img";
    }
    $sql .= " FROM students WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $fname = $row['fname'];
        $lname = $row['lname'];
        $email = $row['email'];
        if ($profile_img_exists && !empty($row['profile_img'])) {
            $profile_img = $row['profile_img'];
        }
    }
    mysqli_stmt_close($stmt);
}

// ✅ Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $user_id !== null) {
    $fname = mysqli_real_escape_string($conn, trim($_POST['fname']));
    $lname = mysqli_real_escape_string($conn, trim($_POST['lname']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));

    $update_sql = "UPDATE students SET fname=?, lname=?, email=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($stmt, "sssi", $fname, $lname, $email, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Profile updated successfully!";
        header("Location: profile.php"); // Reload the page to show updated data
        exit;
    } else {
        $_SESSION['error'] = "Something went wrong. Try again!";
    }

    mysqli_stmt_close($stmt);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <style>
        body, html {
            overflow-x: hidden;
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            background: #343a40;
            color: white;
            padding-top: 20px;
            transition: left 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            z-index: 1050;
        }
        @media (min-width: 769px) {
            .sidebar {
                left: 0;
            }
            .main-content {
                margin-left: 250px;
            }
        }
        @media (max-width: 768px) {
            .sidebar.open {
                left: 0;
                width: 100%;
            }
            .main-content {
                margin-left: 0;
            }
            .close-icon {
                display: block !important;
            }
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: #495057;
        }
        .close-icon {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
            color: white;
            display: none;
        }
        .profile-card {
            max-width: 500px;
            margin: 80px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1029;
        }
        .overlay.show {
            display: block;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            text-align: left;
        }
    </style>

    <script>
        function toggleSidebar() {
            if (window.innerWidth < 769) { 
                document.querySelector(".sidebar").classList.toggle("open");
                document.querySelector(".overlay").classList.toggle("show");
            }
        }
        window.addEventListener("resize", function () {
            if (window.innerWidth >= 769) {
                document.querySelector(".sidebar").classList.remove("open");
                document.querySelector(".overlay").classList.remove("show");
            }
        });
    </script>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <span class="navbar-toggler-icon" style="margin-left: 15px; cursor: pointer;" onclick="toggleSidebar()"></span>
        <span class="navbar-brand mx-auto">Dashboard</span>
    </nav>

    <div class="overlay" onclick="toggleSidebar()"></div>

    <div class="sidebar">
        <span class="close-icon material-icons" onclick="toggleSidebar()">close</span>
        <h4 class="text-center mt-4">Tech Clone Pvt Ltd.</h4>
        <div class="text-center">
            <img src="<?php echo $profile_img; ?>" width="50" height="50" alt="User" class="rounded-circle">
            <p><?php echo htmlspecialchars($fname . " " . $lname); ?></p>
        </div>
        <hr>
        <a href="dashboard.php"><i class="material-icons">dashboard</i> Dashboard</a>
        <a href="profile.php"><i class="material-icons">person</i> Profile</a>
        <a href="product.php"><i class="material-icons">shopping_cart</i> Products</a>
        <a href="category.php"><i class="material-icons">list</i> Categories</a>
        <a href="contact.php"><i class="material-icons">contacts</i> Contact</a>
        <a href="sign-out.php"><i class="material-icons">logout</i> Log-out</a>
    </div>

    <div class="container main-content">
        <div class="profile-card">
            <h3>User Profile</h3>
            <?php if(isset($_SESSION['success'])) { ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php } ?>
            <?php if(isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php } ?>

            <form method="post">
                <div class="form-group">
                    <label>First Name:</label>
                    <input type="text" class="form-control" name="fname" value="<?php echo htmlspecialchars($fname); ?>">
                </div>
                <div class="form-group">
                    <label>Last Name:</label>
                    <input type="text" class="form-control" name="lname" value="<?php echo htmlspecialchars($lname); ?>">
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>">
                </div>
                
                <button type="submit" class="btn btn-success btn-block">Save Changes</button>
            </form>
        </div>
    </div>
</body>
</html>
