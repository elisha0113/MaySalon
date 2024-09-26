<?php
include 'setup.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment_id = $_POST['id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $status = $_POST['status'];

    // Define allowed status values
    $allowed_statuses = ['Scheduled', 'Completed', 'Canceled'];

    if (!in_array($status, $allowed_statuses)) {
        die('Invalid status value.');
    }

    // Prepare and execute the query
    $query = "UPDATE appointments SET AppointmentDate = ?, AppointmentTime = ?, Status = ? WHERE AppointmentID = ?";
    $stmt = $con->prepare($query);
    
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($con->error));
    }

    $stmt->bind_param("sssi", $date, $time, $status, $appointment_id);

    if ($stmt->execute()) {
        echo "Appointment updated successfully.";
    } else {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}
?>
