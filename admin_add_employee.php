<?php
include 'setup.php';

// Handle form submission
if (isset($_POST['add_employee'])) {
    $name = mysqli_real_escape_string($con, $_POST['Name']);
    $email = mysqli_real_escape_string($con, $_POST['Email']);
    $phone = mysqli_real_escape_string($con, $_POST['Phone']);
    $roleID = mysqli_real_escape_string($con, $_POST['RoleID']);
    $hireDate = mysqli_real_escape_string($con, $_POST['HireDate']);
    $status = mysqli_real_escape_string($con, $_POST['EmployeeStatus']);
    $icNumber = mysqli_real_escape_string($con, $_POST['ICNumber']);
    $salary = mysqli_real_escape_string($con, $_POST['Salary']);

    // Insert the employee record into the database
    $insertQuery = "INSERT INTO employees (Name, Email, Phone, RoleID, HireDate, EmployeeStatus, ICNumber, Salary)
                    VALUES ('$name', '$email', '$phone', '$roleID', '$hireDate', '$status', '$icNumber', '$salary')";

    if (mysqli_query($con, $insertQuery)) {
        echo "Employee added successfully!";
    } else {
        echo "Error adding employee: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
</head>
<body>

<h2>Add New Employee</h2>

<form method="POST">
    <label for="Name">Name:</label>
    <input type="text" name="Name" required><br>

    <label for="Email">Email:</label>
    <input type="email" name="Email" required><br>

    <label for="Phone">Phone:</label>
    <input type="text" name="Phone" required><br>

    <label for="RoleID">Role:</label>
    <select name="RoleID" required>
        <?php
        // Fetch available roles from the database
        $roleQuery = "SELECT * FROM roles";
        $roleResult = mysqli_query($con, $roleQuery);

        while ($role = mysqli_fetch_assoc($roleResult)) {
            echo "<option value='" . $role['RoleID'] . "'>" . $role['RoleName'] . "</option>";
        }
        ?>
    </select><br>

    <label for="HireDate">Hire Date:</label>
    <input type="date" name="HireDate" required><br>

    <label for="EmployeeStatus">Status:</label>
    <select name="EmployeeStatus" required>
        <option value="Active">Active</option>
        <option value="On Leave">On Leave</option>
        <option value="Retired">Retired</option>
        <option value="Resigned">Resigned</option>
    </select><br>

    <label for="ICNumber">IC Number:</label>
    <input type="text" name="ICNumber" required><br>

    <label for="Salary">Salary:</label>
    <input type="number" name="Salary" step="0.01" required><br>

    <button type="submit" name="add_employee">Add Employee</button>
</form>

<!-- Button to go back to the admin dashboard -->
<br>
<a href="admin.php?page=employees">
    <button type="button">Back to Admin Page</button>
</a>

</body>
</html>
