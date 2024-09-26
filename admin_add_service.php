<?php
include 'setup.php'; // Connect to the database

// Handle form submission to add a new service
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $price = $_POST['price'];
    $role_id = $_POST['role_id'];
    $service_img = !empty($_POST['service_img_name']) ? $_POST['service_img_name'] : NULL; // Optional image name

    // Insert new service into the database
    $insert_query = "INSERT INTO services (ServiceName, Description, Duration, Price, RoleID, service_img_name)
                     VALUES ('$service_name', '$description', $duration, $price, $role_id, '$service_img')";

    if (mysqli_query($con, $insert_query)) {
        header("Location: admin_service.php"); // Redirect to services page after adding
    } else {
        echo "Failed to add service: " . mysqli_error($con);
    }
}

// Fetch roles for the dropdown
$roles_query = "SELECT * FROM roles";
$roles_result = mysqli_query($con, $roles_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Service</title>
    <link rel="stylesheet" href="admin_style.css">
</head>

<body>

    <h1>Add New Service</h1>
    <form method="POST" action="">
        <label for="service_name">Service Name:</label>
        <input type="text" id="service_name" name="service_name" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br>

        <label for="duration">Duration (in minutes):</label>
        <input type="number" id="duration" name="duration" required><br>

        <label for="price">Price (RM):</label>
        <input type="number" id="price" name="price" required><br>

        <label for="role_id">Role:</label>
        <select id="role_id" name="role_id" required>
            <?php
            while ($role_row = mysqli_fetch_assoc($roles_result)) {
                echo "<option value='{$role_row['RoleID']}'>{$role_row['RoleName']}</option>";
            }
            ?>
        </select><br>

        <label for="service_img_name">Service Image Name (optional):</label>
        <input type="text" id="service_img_name" name="service_img_name"><br>

        <button type="submit">Add Service</button>
    </form>
<a href="admin.php?page=services">Back to Services List</a>
</body>

</html>
