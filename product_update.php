<?php 
session_start();
include("conn.php");

if (empty($_SESSION)) {
    header("location:sign-in.php");
    exit();
}

$fname = "Parmanand";
$lname = "Rai";

// Initialize product variable
$product = null;
$product_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Validate product ID
if ($product_id <= 0) {
    die("Invalid product ID!");
    header("product.php");
}

// Fetch product details
$sql = "SELECT * FROM product WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $product = mysqli_fetch_assoc($result);
} else {
    die("Product not found!");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $stock = trim($_POST['stock']);
    $description = trim($_POST['description']);

    $update_sql = "UPDATE product SET name = ?, price = ?, stock = ?, description = ? WHERE id = ?";
    $update_stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "ssisi", $name, $price, $stock, $description, $product_id);
    
    if (mysqli_stmt_execute($update_stmt)) {
        echo "<script>alert('Product updated successfully!'); window.location.href = 'product.php';</script>";
    } else {
        echo "<script>alert('Error updating product!');</script>";
    }
    
    mysqli_stmt_close($update_stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Product</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .top-navbar {
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background: #343a40;
            color: white;
            padding: 10px 20px;
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50px;
            font-size: 20px;
            font-weight: bold;
            transition: opacity 0.3s ease-in-out;
        }

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
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
        }

        .sidebar a:hover {
            background: #495057;
        }

        .toggle-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            font-size: 24px;
            cursor: pointer;
            color: white;
            z-index: 1001;
            display: none !important; /* Hidden on large screens */
        }

        .close-btn {
            display: none;
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
            color: white;
        }

        .main-content {
            margin-left: 260px;
            padding: 20px;
            min-height: 100vh;
            background: #f8f9fa;
            transition: margin-left 0.3s ease-in-out;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 100%;
                position: fixed;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .toggle-btn {
                display: block; /* Show toggle button on small screens */
            }

            .close-btn {
                display: block !important;
            }

            .main-content {
                margin-left: 0;
            }

            .top-navbar.hidden {
                opacity: 0;
                pointer-events: none;
            }
        }
    </style>
</head>
<body>

    <nav class="top-navbar" id="top-navbar">
        Product Management
    </nav>
    
    <i class="material-icons toggle-btn" id="toggle-btn" onclick="toggleSidebar()">menu</i>

    <div class="sidebar" id="sidebar">
        <i class="material-icons close-btn" id="close-btn" onclick="toggleSidebar()">close</i>
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
        <a href="contact.php"><i class="material-icons">contact_mail</i> Contact</a>
        <a href="sign-out.php"><i class="material-icons">exit_to_app</i> Log-out</a>
    </div>

    <div class="main-content">
        <div class="container mt-5 product-form">
            <h2>Update Product</h2>
            <form action="" method="POST">
                <label>Name:</label>
                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" required>
                <label>Price:</label>
                <input type="text" name="price" class="form-control" value="<?php echo htmlspecialchars($product['price'] ?? ''); ?>" required>
                <label>Stock:</label>
                <input type="text" name="stock" class="form-control" value="<?php echo htmlspecialchars($product['stock'] ?? ''); ?>" required>
                <label>Description:</label>
                <textarea name="description" class="form-control" required><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
                <button type="submit" class="btn btn-primary mt-3">Update</button>
            </form>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            let sidebar = document.getElementById("sidebar");
            let toggleBtn = document.getElementById("toggle-btn");
            let closeBtn = document.getElementById("close-btn");
            let topNavbar = document.getElementById("top-navbar");

            sidebar.classList.toggle("open");

            if (sidebar.classList.contains("open")) {
                toggleBtn.style.display = "none"; 
                closeBtn.style.display = "block"; 
                topNavbar.classList.add("hidden"); 
            } else {
                toggleBtn.style.display = "block"; 
                closeBtn.style.display = "none"; 
                topNavbar.classList.remove("hidden"); 
            }
        }
    </script>

</body>
</html>
