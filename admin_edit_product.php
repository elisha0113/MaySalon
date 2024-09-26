<?php
session_start();
include 'setup.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION["AdminID"])) {
    header("Location: admin_login.php");
    exit();
}

// Check if ProductID is set in the URL
if (isset($_GET['id'])) {
    $product_id = mysqli_real_escape_string($con, $_GET['id']);

    // Fetch product details for editing
    $query = "SELECT * FROM products WHERE ProductID='$product_id'";
    $result = mysqli_query($con, $query);
    $product = mysqli_fetch_assoc($result);

    // Check if the product exists
    if (!$product) {
        echo "<script>alert('Product not found.'); window.location.href='admin.php?page=products';</script>";
        exit();
    }

    // Handle form submission for updating the product
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect and sanitize form inputs
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $price = mysqli_real_escape_string($con, $_POST['price']);
        $stock = mysqli_real_escape_string($con, $_POST['stock']);
        $status = ($stock == 0) ? 'Out of stock' : mysqli_real_escape_string($con, $_POST['status']);
        $description = mysqli_real_escape_string($con, $_POST['description']);
        $category_id = mysqli_real_escape_string($con, $_POST['category']);

        // Update product in the database
        $query = "UPDATE products SET Name='$name', Price='$price', Stock='$stock', Status='$status', Details='$description', CategoryID='$category_id' 
                  WHERE ProductID='$product_id'";

        if (mysqli_query($con, $query)) {
            echo "<script>alert('Product updated successfully'); window.location.href='admin.php?page=products';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
} else {
    echo "<script>alert('No ProductID specified.'); window.location.href='admin.php?page=products';</script>";
    exit();
}

// Fetch all categories for the category dropdown
$category_query = "SELECT * FROM productcategories";
$category_result = mysqli_query($con, $category_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Product</h2>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['Name']); ?>" required>

        <label for="price">Price:</label>
        <input type="text" name="price" value="<?php echo htmlspecialchars($product['Price']); ?>" required>

        <label for="stock">Stock:</label>
        <input type="number" name="stock" value="<?php echo htmlspecialchars($product['Stock']); ?>" required>

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="Available" <?php if ($product['Status'] == 'Available') echo 'selected'; ?>>Available</option>
            <option value="No longer sold" <?php if ($product['Status'] == 'No longer sold') echo 'selected'; ?>>No longer sold</option>
            <option value="Out of stock" <?php if ($product['Status'] == 'Out of stock') echo 'selected'; ?>>Out of stock</option>
        </select>

        <label for="description">Description:</label>
        <textarea name="description" required><?php echo htmlspecialchars($product['Details']); ?></textarea>

        <label for="category">Category:</label>
        <select name="category" required>
            <?php while ($category = mysqli_fetch_assoc($category_result)) { ?>
                <option value="<?php echo $category['CategoryID']; ?>" <?php if ($product['CategoryID'] == $category['CategoryID']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($category['CategoryName']); ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Update Product</button>
    </form>
    <a href="admin.php?page=products">Back to Product List</a>
</body>
</html>
