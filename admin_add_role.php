<?php
session_start();
include 'setup.php';

if (!isset($_SESSION["AdminID"])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form inputs
    $role_name = mysqli_real_escape_string($con, $_POST['role_name']);
    $role_categories = mysqli_real_escape_string($con, $_POST['role_categories']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    // Insert new role into the database
    $query = "INSERT INTO roles (RoleName, RoleCategoryID, Description) 
              VALUES ('$role_name', '$role_categories', '$description')";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Role added successfully'); window.location.href='admin.php?page=roles';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Role</title>
</head>
<body>
    <h2>Add Role</h2>
    <form method="POST">
        <label for="role_name">Role Name:</label>
        <input type="text" name="role_name" required>

        <label for="role_categories">Role Categories:</label>
        <select name="role_categories" required>
            <?php
            // Fetch role categories from the database
            $query = "SELECT RoleCategoryID, CategoryName FROM rolecategories";
            $result = mysqli_query($con, $query);

            // Check if there are any categories
            if (mysqli_num_rows($result) > 0) {
                // Output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['RoleCategoryID'] . "'>" . $row['CategoryName'] . "</option>";
                }
            } else {
                echo "<option value=''>No categories available</option>";
            }
            ?>
        </select>

        <label for="description">Description:</label>
        <textarea name="description" required></textarea>

        <button type="submit">Add Role</button>
    </form>

<a href="admin.php?page=employees">
    <button type="button">Back to Admin Page</button>
</a>

</body>
</html>
