<?php
$fname = "Parmanand";
$lname = "Rai";

include("conn.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $user_id = $_SESSION['id'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    $sku = $_POST['sku'];
    $status = $_POST['status'];
    $category_id = $_POST['category'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $query = "INSERT INTO product (name, price, user_id, stock, image, description, sku, status, category_id) 
                      VALUES ('$name', '$price', '$user_id', '$stock', '$target_file', '$description', '$sku', '$status', '$category_id')";
            mysqli_query($conn, $query);
        }
    }
}

$category_query = "SELECT id, name FROM category";
$category_result = mysqli_query($conn, $category_query);

$product_query = "SELECT * FROM product WHERE user_id = '{$_SESSION['id']}'";
$product_result = mysqli_query($conn, $product_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        body {
            overflow-x: hidden;
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
            transition: all 0.3s ease;
            z-index: 1050;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px 20px;
        }
        .sidebar a i {
           margin-right: 10px; /* Adjust spacing as needed */
        }
        .sidebar a:hover {
            background: #495057;
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
            display:none;
        }

        .main-content {
            margin-left: 0;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .top-navbar {
            width: 100%;
            background: #343a40;
            color: white;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1040;
        }

        .menu-btn {
            font-size: 30px;
            cursor: pointer;
            
        }

        .table img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        @media (min-width: 768px) {
            .sidebar {
                left: 0;
            }
            .main-content {
                margin-left: 250px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                left: -100%;
            }
            .sidebar.active {
                left: 0;
            }
            .close-btn{
                display: block;
            }
        }
    </style>
</head>
<body>
<script>
    function toggleSidebar() {
        var sidebar = document.getElementById("sidebar");
        sidebar.classList.toggle("active");
    }
</script>
    <div class="sidebar" id="sidebar">
        <span class="close-btn material-icons" onclick="toggleSidebar()">close</span>
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

    <nav class="navbar top-navbar">
        <span class="menu-btn material-icons" onclick="toggleSidebar()">menu</span>
        <span class="navbar-brand mx-auto">Dashboard</span>
    </nav>

    <div class="main-content" style="margin-top: 60px;">
        <h2 class="mb-4">Add Product</h2>
        <form action="product.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="text" class="form-control" name="price" required>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category" class="form-control" required>
                    <option value="">Select a Category</option>
                    <?php while ($row = mysqli_fetch_assoc($category_result)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Stock</label>
                <input type="text" class="form-control" name="stock" required>
            </div>
            <div class="form-group">
                <label>SKU</label>
                <input type="text" class="form-control" name="sku" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" class="form-control" name="image" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" name="description"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Add Product</button>
        </form>

        <h2 class="mt-5">Product List</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Image</th>
                        <th>SKU</th>
                        <th>Status</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($product_result)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['stock']; ?></td>
                            <td><img src="<?php echo $row['image']; ?>" width="50"></td>
                            <td><?php echo $row['sku']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['category_id']; ?></td>
                            <td>
    <a href="product_update.php?id=<?php echo $row['id']; ?>" class="text-warning mx-2">
        <i class="material-icons">edit</i>
    </a>
    <a href="product_delete.php?id=<?php echo $row['id']; ?>" class="text-danger mx-2" onclick="return confirm('Are you sure you want to delete this product?');">
        <i class="material-icons">delete</i>
    </a>
</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
