<?php
include 'setup.php'; // Connect to the database

// Fetch all services from the database
$query = "SELECT * FROM services";
$result = mysqli_query($con, $query);

// Check if the query was successful
if (!$result) {
    // Show error message if query fails
    echo "Error fetching services: " . mysqli_error($con);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Services</title>
    <link rel="stylesheet" href="admin_style.css">
</head>

<body>
    <h1>All Services</h1>

    <!-- Add Service Button -->
    <a href="admin_add_service.php">Add New Service</a>

    <!-- Display all services -->
    <table border="1">
        <tr>
            <th>Service Name</th>
            <th>Description</th>
            <th>Duration</th>
            <th>Price</th>
            <th>Role</th>
            <th>Service Image</th>
            <th>Edit</th>
        </tr>

        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['ServiceName'] . "</td>";
            echo "<td>" . $row['Description'] . "</td>";
            echo "<td>" . $row['Duration'] . " minutes</td>";
            echo "<td>RM " . $row['Price'] . "</td>";
            echo "<td>" . $row['RoleID'] . "</td>";
            echo "<td>" . $row['service_img_name'] . "</td>";
            echo "<td><a href='admin_edit_service.php?edit=" . $row['ServiceID'] . "'>Edit</a></td>";
            echo "</tr>";
        }
        ?>
    </table>

</body>

</html>
