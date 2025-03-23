<?php
include("conn.php");
$sql = "SELECT * FROM students";
$result = mysqli_query($conn, $sql);
?>

<!doctype html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous">
    
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        /* Table styling */
        table {
            margin-top: 20px;
        }

        /* Content section */
        .content-wrapper {
            margin-top: 50px;
        }

        /* Form container styling */
        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }

        /* Adjust form padding for smaller screens */
        @media (max-width: 768px) {
            .form-container {
                width: 100%;
                padding: 10px;
            }
        }

        /* Center table for smaller screens */
        @media (max-width: 768px) {
            .table-responsive {
                margin: 0 auto;
            }
        }
    </style>
</head>
<body>
    <!-- Main Content -->
    <div class="container-fluid content-wrapper">
        <!-- Form Section -->
        <div class="row justify-content-center">
            <div class="col-md-8 form-container">
                <h3 class="text-center">Sign Up</h3>
                <form action="sign-up.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="fname">First Name:</label>
                        <input type="text" class="form-control" name="fname" id="fname" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="lname">Last Name:</label>
                        <input type="text" class="form-control" name="lname" id="lname" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="file">Profile Picture:</label>
                        <input type="file" class="form-control" name="file" id="file" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-success text-uppercase btn-block">Sign Up</button>
                        <a href="sign-in.php" class="btn btn-link text-uppercase d-block text-center">Already a user? Sign In</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Section -->
        <!-- <div class="row justify-content-center mt-5">
            <div class="col-md-10">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="bg-success text-white">
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($show = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>{$show['id']}</td>";
                                    echo "<td>{$show['fname']}</td>";
                                    echo "<td>{$show['lname']}</td>";
                                    echo "<td>{$show['email']}</td>";
                                    echo "<td>{$show['password']}</td>";
                                    echo "<td>
                                        <a class='btn btn-sm btn-info' href='update.php?id={$show['id']}'>Edit</a>
                                        <a class='btn btn-sm btn-danger' href='delete.php?id={$show['id']}'>Delete</a>
                                        </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>No Record Found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Bootstrap JS and Popper.js CDN -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
