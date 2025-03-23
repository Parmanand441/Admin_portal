<?php
include("conn.php");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch categories from the database
$categories = [];
$sql = "SELECT id, name FROM category";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $parent_category = $conn->real_escape_string($_POST['name']);
    $status = $conn->real_escape_string($_POST['status']);

    // Fixing SQL syntax
    $sql = "INSERT INTO category (name, status) VALUES ('$parent_category', '$status')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Category added successfully!";
        header("location:product.php");
    } else {
        $error_message = "Error: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body, html {
            overflow-x: hidden;
            width: 100%;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 56px; /* Push below navbar */
            left: -250px;
            background: #343a40;
            color: white;
            padding-top: 20px;
            transition: left 0.3s ease-in-out;
            z-index: 1050 !important;
        }

        .sidebar.open {
            width: 100%;
            left: 0;
            z-index: 1050 !important;
        }

        /* Sidebar Title */
        .sidebar h4 {
            margin-top: 20px;
            text-align: center;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            transition: 0.3s;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar a:hover {
            background: #495057;
        }

        /* Close Icon */
        .close-icon {
            display: none;
        }

        @media (max-width: 768px) {
            .close-icon {
                display: block;
                position: absolute;
                top: 15px;
                right: 15px;
                font-size: 24px;
                cursor: pointer;
                color: white;
            }

            .close-icon:hover {
                color: #dc3545;
            }
            .sidebar{
                top:0;
            }
        }

        /* Navbar */
        .navbar {
            z-index: 1060;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            height: 56px;
            transition: transform 0.3s ease-in-out;
        }

        /* Hide navbar when sidebar is open on small screens */
        @media (max-width: 768px) {
            .sidebar.open + .navbar {
                transform: translateY(-100%);
            }
        }

        /* Toggle Button */
        .menu-toggle {
            margin-left: 15px;
            cursor: pointer;
        }

        @media (min-width: 768px) {
            .menu-toggle {
                display: none; /* Hide on large screens */
            }
        }

        /* Main Content */
        .main-content {
            margin-left: 0;
            padding: 20px;
            transition: 0.3s ease-in-out;
            margin-top: 60px; /* Push below navbar */
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

        /* Category Form */
        .category-form-container {
            position: relative;
            z-index: 1;
        }

        @media (min-width: 768px) {
            .sidebar {
                left: 0;
            }

            .main-content {
                margin-left: 250px;
            }

            .overlay {
                display: none !important;
            }
        }
    </style>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector(".sidebar");
            const overlay = document.querySelector(".overlay");
            const navbar = document.querySelector(".navbar");

            sidebar.classList.toggle("open");
            overlay.classList.toggle("show");

            // Hide navbar when sidebar opens on small screens
            if (window.innerWidth <= 768) {
                navbar.style.transform = sidebar.classList.contains("open") ? "translateY(-100%)" : "translateY(0)";
            }
        }
    </script>

</head>
<body>

    <!-- Top Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <span class="menu-toggle navbar-toggler-icon" onclick="toggleSidebar()"></span>
        <span class="navbar-brand mx-auto">Dashboard</span>
    </nav>

    <!-- Overlay -->
    <div class="overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <div class="sidebar">
        <span class="close-icon material-icons" onclick="toggleSidebar()">close</span>
        <h4 class="text-center mt-4">Tech Clone Pvt Ltd.</h4>
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
        <div class="container category-form-container">
            <h2 class="text-center">Add Category</h2>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <form action="category.php" method="POST">
                                <div class="form-group mb-3">
                                    <label for="parent_category">Select Category:</label>
                                    <select name="name" class="form-control">
                                        <option value="">None</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="status">Status:</label>
                                    <select name="status" class="form-control" required>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>

                                <div class="form-group mt-3">
                                    <input type="submit" value="Submit" class="btn btn-success btn-block">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
