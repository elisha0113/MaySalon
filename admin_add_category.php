<?php
// Include the database connection
include('setup.php');

// Initialize variables
$category_name = '';
$description = '';
$message = '';

// Check if the form is submitted
if (isset($_POST['add_category'])) {
    $category_name = mysqli_real_escape_string($con, $_POST['category_name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    // Insert the new category into the database
    $insert_query = "INSERT INTO productcategories (CategoryName, Description) VALUES ('$category_name', '$description')";
    
    if (mysqli_query($con, $insert_query)) {
        $message = "Category added successfully!";
    } else {
        $message = "Error adding category: " . mysqli_error($con);
    }
}
?>

<h2>Add Category</h2>

<?php if ($message) { echo "<p>$message</p>"; } ?>

<!-- Add category form -->
<form method="POST" action="">
    <label for="category_name">Category Name:</label>
    <input type="text" name="category_name" required placeholder="Enter category name">

    <label for="description">Description:</label>
    <textarea name="description" placeholder="Enter category description"></textarea>

    <input type="submit" name="add_category" value="Add Category">
</form>

<a href="admin.php?page=products">Back to Products</a>
