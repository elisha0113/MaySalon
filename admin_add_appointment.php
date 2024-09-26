<?php
include 'setup.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
    $employee_id = $_POST['employee_id'];
    $service_id = $_POST['service_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $status = $_POST['status'];

    // Insert the new appointment into the database
    $query = "INSERT INTO appointments (CustomerID, EmployeeID, ServiceID, AppointmentDate, AppointmentTime, Status) 
              VALUES ('$customer_id', '$employee_id', '$service_id', '$appointment_date', '$appointment_time', '$status')";

    if (mysqli_query($con, $query)) {
        echo "Appointment added successfully.";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!-- HTML Form for adding a new appointment -->
<form method="POST">
    <label for="customer_id">Customer ID:</label>
    <input type="text" name="customer_id" required><br>
    
    <label for="employee_id">Employee ID:</label>
    <input type="text" name="employee_id" required><br>
    
    <label for="service_id">Service ID:</label>
    <input type="text" name="service_id" required><br>
    
    <label for="appointment_date">Appointment Date:</label>
    <input type="date" name="appointment_date" required><br>
    
    <label for="appointment_time">Appointment Time:</label>
    <input type="time" name="appointment_time" required><br>
    
    <label for="status">Status:</label>
    <select name="status" required>
        <option value="Scheduled">Scheduled</option>
        <option value="Completed">Completed</option>
        <option value="Canceled">Canceled</option>
    </select><br>
    
    <button type="submit">Add Appointment</button>
</form>
