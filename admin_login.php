<?php
session_start();
include 'setup.php';  // Assuming this file sets up the database connection.

if (isset($_POST['admin_id']) && isset($_POST['admin_pwd'])) {
    // Get admin credentials from the form.
    $admin_id = mysqli_real_escape_string($con, $_POST['admin_id']);
    $admin_pwd = mysqli_real_escape_string($con, $_POST['admin_pwd']);

    // Query to check if the admin exists in the database.
    $query = mysqli_query($con, "SELECT * FROM admins WHERE AdminID='$admin_id'");
    $row = mysqli_fetch_assoc($query);

    if (mysqli_num_rows($query) == 0) {
        // If AdminID is not found.
        echo "<script>alert('Admin ID not found');</script>";
    } else {
        // Check if the password matches.
        if ($row['Password'] === $admin_pwd) {
            // Set session variable for the admin.
            $_SESSION["AdminID"] = $row['AdminID'];
            $_SESSION["AdminName"] = $row['Name'];

            // Redirect to the admin dashboard or homepage.
            header("Location: admin.php");
            exit();
        } else {
            // If the password is incorrect.
            echo "<script>alert('Incorrect password');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adminlogin_style.css"> 
    <title>Admin Login</title>
</head>

<body>
    <div class="login-container">
        <form method="POST">
            <h2>Admin Login</h2>
            
            <input type="text" name="admin_id" placeholder="Admin ID" required>
            <input type="password" name="admin_pwd" placeholder="Password" required>
            
            <button type="submit" class="button">Log In</button>
        </form>
    </div>
</body>

</html>
