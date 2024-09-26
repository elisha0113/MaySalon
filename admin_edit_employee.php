<?php
include 'setup.php';

// Check if employee ID is set in the URL
if (isset($_GET['id'])) {
    $employeeID = $_GET['id'];

    // Fetch employee details including role
    $query = "SELECT e.*, r.RoleName FROM employees e
              LEFT JOIN roles r ON e.RoleID = r.RoleID
              WHERE e.EmployeeID = '$employeeID'";
    $result = mysqli_query($con, $query);
    $employee = mysqli_fetch_assoc($result);

    if (!$employee) {
        echo "Employee not found!";
        exit();
    }
} else {
    echo "Employee ID not provided!";
    exit();
}

// Handle form submission
if (isset($_POST['update_employee'])) {
    $email = mysqli_real_escape_string($con, $_POST['Email']);
    $phone = mysqli_real_escape_string($con, $_POST['Phone']);
    $roleID = mysqli_real_escape_string($con, $_POST['RoleID']);
    $status = mysqli_real_escape_string($con, $_POST['EmployeeStatus']);

    // Update the employee record in the database
    $updateQuery = "UPDATE employees 
                    SET Email = '$email', Phone = '$phone', RoleID = '$roleID', EmployeeStatus = '$status' 
                    WHERE EmployeeID = '$employeeID'";

    if (mysqli_query($con, $updateQuery)) {
        echo "Employee updated successfully!";
    } else {
        echo "Error updating employee: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
</head>
<body>

<h2>Edit Employee</h2>

<form method="POST">
    <label for="Email">Email:</label>
    <input type="email" name="Email" value="<?php echo $employee['Email']; ?>" required><br>

    <label for="Phone">Phone:</label>
    <input type="text" name="Phone" value="<?php echo $employee['Phone']; ?>" required><br>

    <label for="RoleID">Role:</label>
    <select name="RoleID" required>
        <?php
        // Fetch available roles from the database
        $roleQuery = "SELECT * FROM roles";
        $roleResult = mysqli_query($con, $roleQuery);

        while ($role = mysqli_fetch_assoc($roleResult)) {
            $selected = ($employee['RoleID'] == $role['RoleID']) ? 'selected' : '';
            echo "<option value='" . $role['RoleID'] . "' $selected>" . $role['RoleName'] . "</option>";
        }
        ?>
    </select><br>

    <label for="EmployeeStatus">Status:</label>
    <select name="EmployeeStatus" required>
        <option value="Active" <?php if ($employee['EmployeeStatus'] == 'Active') echo 'selected'; ?>>Active</option>
        <option value="On Leave" <?php if ($employee['EmployeeStatus'] == 'On Leave') echo 'selected'; ?>>On Leave</option>
        <option value="Retired" <?php if ($employee['EmployeeStatus'] == 'Retired') echo 'selected'; ?>>Retired</option>
        <option value="Resigned" <?php if ($employee['EmployeeStatus'] == 'Resigned') echo 'selected'; ?>>Resigned</option>
    </select><br>

    <button type="submit" name="update_employee">Update Employee</button>
</form>

<!-- Button to go back to the admin dashboard -->
<br>
<a href="admin.php?page=employees">
    <button type="button">Back to Admin Page</button>
</a>

</body>
</html>
