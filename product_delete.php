<?php
include("conn.php");

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $sql = "DELETE FROM product WHERE id = $product_id";
    if (mysqli_query($conn, $sql)) {
        echo "Product deleted successfully.";
        header("Location: product.php");
        exit;
    } else {
        echo "Error deleting product: " . mysqli_error($conn);
    }
} else {
    echo "No product ID provided.";
    header("product.php");
}

mysqli_close($conn);
?>
