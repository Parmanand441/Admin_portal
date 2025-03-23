<?php
$fname = "Parmanand";
$lname = "Rai";
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
        body, html {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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

        /* Sidebar Close Button (only for small screens) */
        .sidebar .close-btn {
            position: absolute;
            top: 20px;
            right: 30px;
            cursor: pointer;
            color: white;
            font-size: 24px;
            display: none;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 80px 20px 20px;
            flex-grow: 1;
            transition: margin-left 0.3s ease-in-out;
        }

        /* Navbar */
        .top-navbar {
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        /* Footer */
        .footer {
            background: #343a40;
            color: white;
            padding: 10px 0;
            text-align: center;
            width: 100%;
        }

        .footer .social-icons a {
            color: white;
            margin: 0 10px;
            font-size: 20px;
            transition: 0.3s;
        }

        .footer .social-icons a:hover {
            color: #28a745;
        }

        /* Responsive Fixes */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                width: 100%;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                transition: margin-left 0.3s ease-in-out;
            }

            /* Sidebar close button is visible only on small screens */
            .sidebar .close-btn {
                display: block;
            }

            /* Overlay for small screens */
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
        }

        /* Hide toggle menu icon on large screens */
        @media (min-width: 769px) {
            .menu-toggle {
                display: none;
            }
        }
    </style>

    <script>
        function toggleSidebar() {
            document.querySelector(".sidebar").classList.toggle("open");
            document.querySelector(".overlay").classList.toggle("show");
        }
    </script>

</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark fixed-top top-navbar">
        <button class="btn btn-dark menu-toggle d-md-none" type="button" onclick="toggleSidebar()">
            <i class="material-icons">menu</i>
        </button>
        <span class="navbar-brand mx-auto">Dashboard</span>
    </nav>

    <!-- Overlay (for small screens) -->
    <div class="overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <div class="sidebar">
        <span class="close-btn" onclick="toggleSidebar()"><i class="material-icons">close</i></span>
        <h4 class="text-center">Tech Clone Pvt Ltd.</h4>
        <div class="text-center">
            <img src="images/Untitled Project.jpg" width="50" height="50" alt="User" class="rounded-circle">
            <p><?php echo $fname . " " . $lname; ?></p>
        </div>
        <hr>
        <a href="dashboard.php"><i class="material-icons">dashboard</i> Dashboard</a>
        <a href="profile.php"><i class="material-icons">person</i> Profile</a>
        <a href="product.php"><i class="material-icons">shopping_cart</i> Products</a>
        <a href="category.php"><i class="material-icons">list</i> Categories</a>
        <a href="contact.php"><i class="material-icons">contacts</i> Contact</a>
        <a href="sign-out.php"><i class="material-icons">logout</i> Log-out</a>
    </div>

    <!-- Main Content -->
    <div class="container main-content">
        <h2 class="text-center">Contact Us</h2>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter your full name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" placeholder="Enter subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" rows="2" placeholder="Write your message here" required></textarea>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="container">
            <h5 class="text-uppercase">Tech Clone Pvt Ltd.</h5>
            <p>&copy; <?php echo date("Y"); ?> All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
