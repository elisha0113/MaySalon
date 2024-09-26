<?php
include 'setup.php';

if (!isset($_GET['id'])) {
    echo "No appointment selected.";
    exit();
}

$appointment_id = $_GET['id'];

// Fetch appointment details
$query = "
    SELECT a.*, c.Name AS customer_name
    FROM appointments a
    JOIN customers c ON a.CustomerID = c.CustomerID
    WHERE a.AppointmentID = ?
";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$result = $stmt->get_result();
$appointment = $result->fetch_assoc();

if (!$appointment) {
    echo "Appointment not found.";
    exit();
}
?>

<h2>Appointment Details</h2>
<form action="admin_edit_appointment.php" method="POST">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($appointment['AppointmentID']); ?>">
    <label for="customer_name">Customer Name:</label>
    <input type="text" id="customer_name" name="customer_name" value="<?php echo htmlspecialchars($appointment['customer_name']); ?>" readonly>
    <br>
    <label for="date">Date:</label>
    <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($appointment['AppointmentDate']); ?>" required>
    <br>
    <label for="time">Time:</label>
    <input type="time" id="time" name="time" value="<?php echo htmlspecialchars($appointment['AppointmentTime']); ?>" required>
    <br>
    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="Scheduled" <?php echo ($appointment['Status'] == 'Scheduled') ? 'selected' : ''; ?>>Scheduled</option>
        <option value="Completed" <?php echo ($appointment['Status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
        <option value="Canceled" <?php echo ($appointment['Status'] == 'Canceled') ? 'selected' : ''; ?>>Canceled</option>
    </select>
    <br>
    <input type="submit" value="Edit Appointment">
</form>
