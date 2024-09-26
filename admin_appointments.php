<?php
include 'setup.php';

// Fetch appointments with customer names
$query = "
    SELECT a.AppointmentID, c.Name AS customer_name, a.EmployeeID, a.ServiceID, a.AppointmentDate, a.AppointmentTime, a.Status
    FROM appointments a
    JOIN customers c ON a.CustomerID = c.CustomerID
";
$result = $con->query($query);
?>

<h2>Appointments Management</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer Name</th>
            <th>Employee ID</th>
            <th>Service ID</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['AppointmentID']; ?></td>
            <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
            <td><?php echo $row['EmployeeID']; ?></td>
            <td><?php echo $row['ServiceID']; ?></td>
            <td><?php echo $row['AppointmentDate']; ?></td>
            <td><?php echo $row['AppointmentTime']; ?></td>
            <td><?php echo $row['Status']; ?></td>
            <td><a href="admin.php?page=appointment_details&id=<?php echo $row['AppointmentID']; ?>">View Details</a></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
