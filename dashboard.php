<?php 
session_start();
if(empty($_SESSION)){
    header("location:sign-in.php");
}

$fname = "Parmanand";
$lname = "Rai";
$profile_img = "images/Untitled Project.jpg"; // Default profile image
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background: #343a40;
            color: white;
            padding-top: 20px;
            transition: transform 0.3s ease-in-out;
            z-index: 1050;
        }

        /* Sidebar full width on small screens */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
        }

        /* Sidebar Links */
        .sidebar a {
            display: flex;
            align-items: center;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            transition: 0.3s;
            font-size: 16px;
        }

        .sidebar a i {
            margin-right: 10px;
            font-size: 20px;
        }

        .sidebar a:hover {
            background: #495057;
            text-decoration: none;
        }

        /* Sidebar Close Button */
        .close-sidebar {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 20px;
            cursor: pointer;
            display: none;
            color:white;
        }

        @media (max-width: 768px) {
            .close-sidebar {
                display: block;
            }
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 80px 20px 20px;
            transition: margin-left 0.3s ease-in-out;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }

        /* Overlay */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1049;
        }

        .overlay.show {
            display: block;
        }

        /* Profile Picture */
        .profile-container {
            text-align: center;
            position: relative;
            padding-bottom: 20px;
        }

        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
        }

        .profile-icons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .profile-icons i {
            cursor: pointer;
            color: white;
            background: rgba(0, 0, 0, 0.6);
            padding: 6px;
            border-radius: 50%;
            font-size: 16px;
        }

        .profile-icons i:hover {
            background: #28a745;
        }

        .sidebar hr {
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* Toggle Menu Button */
        .menu-button {
            font-size: 28px;
            cursor: pointer;
            color: white;
            display: block;
            background: none;
            border: none;
        }
    </style>

</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <button class="btn btn-dark d-md-none menu-button" onclick="toggleSidebar()">
            <i class="material-icons">menu</i>
        </button>
        <span class="navbar-brand mx-auto">Dashboard</span>
    </nav>

    <!-- Overlay -->
    <div class="overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <div class="sidebar">
        <span class="close-sidebar" onclick="toggleSidebar()">✖</span>
        <h4 class="text-center">Tech Clone Pvt Ltd.</h4>
        <div class="profile-container">
            <img src="<?php echo $profile_img; ?>" id="profilePic" class="profile-img" alt="User">
            <div class="profile-icons">
                <i class="material-icons" onclick="document.getElementById('profileUpload').click()">edit</i>
                <i class="material-icons" onclick="removeProfilePic()">delete</i>
            </div>
        </div>
        <input type="file" id="profileUpload" style="display: none;" onchange="previewProfilePic(event)">
        <p class="text-center"><?php echo $fname . " " . $lname; ?></p>
        <hr>
        <a href="dashboard.php"><i class="material-icons">dashboard</i> Dashboard</a>
        <a href="profile.php"><i class="material-icons">person</i> Profile</a>
        <a href="product.php"><i class="material-icons">shopping_cart</i> Products</a>
        <a href="category.php"><i class="material-icons">list</i> Categories</a>
        <a href="contact.php"><i class="material-icons">contacts</i> Contact</a>
        <a href="sign-out.php"><i class="material-icons">logout</i> Log-out</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container mt-5 pt-5">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-success text-uppercase">Welcome to Your Dashboard!</h1>
                    <p class="card-text text-center">Hello, <strong><?php echo $fname . " " . $lname;?></strong>! Manage your profile, view categories, and add Products!</p>
                    <div class="text-center">
                        <a href="product.php" class="btn btn-success text-uppercase">Add Product</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function toggleSidebar() {
            let sidebar = document.querySelector(".sidebar");
            let overlay = document.querySelector(".overlay");
            sidebar.classList.toggle("open");
            overlay.classList.toggle("show");
        }

        function previewProfilePic(event) {
            let reader = new FileReader();
            reader.onload = function(){
                let output = document.getElementById('profilePic');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function removeProfilePic() {
            document.getElementById('profilePic').src = 'images/default-avatar.png';
        }
    </script>

</body>
</html>
