<?php
// Fetch employees with their roles using a JOIN query between employees and roles
$query = "SELECT employees.EmployeeID, employees.Name, employees.Email, employees.Phone, roles.RoleName 
          FROM employees 
          JOIN roles ON employees.RoleID = roles.RoleID";
$result = mysqli_query($con, $query);

if (isset($_POST['search'])) {
    $search_value = mysqli_real_escape_string($con, $_POST['search_value']);
    $query = "SELECT employees.EmployeeID, employees.Name, employees.Email, employees.Phone, roles.RoleName 
              FROM employees 
              JOIN roles ON employees.RoleID = roles.RoleID 
              WHERE employees.Name LIKE '%$search_value%'";
    $result = mysqli_query($con, $query);
}
?>

<h2>Employees Management</h2>

<form method="POST" action="admin.php?page=employees">
    <input type="text" name="search_value" placeholder="Search employees">
    <button type="submit" name="search">Search</button>
</form>

<a href="admin_add_employee.php">Add Employee</a>
<a href="admin_add_role.php">Add Role</a>

<table border="1">
    <thead>
        <tr>
            <th>Employee ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Role</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['EmployeeID']; ?></td>
            <td><?php echo $row['Name']; ?></td>
            <td><?php echo $row['Email']; ?></td>
            <td><?php echo $row['Phone']; ?></td>
            <td><?php echo $row['RoleName']; ?></td> <!-- Display Role Name -->
            <td><a href="admin_edit_employee.php?id=<?php echo $row['EmployeeID']; ?>">Edit</a></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
