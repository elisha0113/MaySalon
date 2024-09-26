<?php
session_start();
include 'setup.php';

if (!isset($_SESSION["AdminID"])) {
    header("Location: admin_login.php");
    exit();
}

$role_id = $_GET['role_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form inputs
    $role_name = mysqli_real_escape_string($con, $_POST['role_name']);
    $role_categories = mysqli_real_escape_string($con, $_POST['role_categories']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    // Update role in the database
    $query = "UPDATE roles SET RoleName='$role_name', RoleCategories='$role_categories', Description='$description' 
              WHERE RoleID='$role_id'";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Role updated successfully'); window.location.href='admin.php?page=roles';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
}

// Fetch role details for editing
$query = "SELECT * FROM roles WHERE RoleID='$role_id'";
$result = mysqli_query($con, $query);
$role = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Role</title>
</head>
<body>
    <h2>Edit Role</h2>
    <form method="POST">
        <label for="role_name">Role Name:</label>
        <input type="text" name="role_name" value="<?php echo $role['RoleName']; ?>" required>

        <label for="role_categories">Role Categories:</label>
        <input type="text" name="role_categories" value="<?php echo $role['RoleCategories']; ?>" required>

        <label for="description">Description:</label>
        <textarea name="description" required><?php echo $role['Description']; ?></textarea>

        <button type="submit">Update Role</button>
    </form>
</body>
</html>
