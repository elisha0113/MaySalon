<?php
error_reporting(E_ALL); // Enable error reporting
ini_set('display_errors', 1); // Show errors

include 'setup.php';

// Check if admin is logged in.
if (!isset($_SESSION["AdminID"])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch schedules for employees that are currently available
$schedules_query = "SELECT s.ScheduleID, e.Name AS EmployeeName, s.Date, s.StartTime, s.EndTime, s.AvailabilityStatus
                    FROM schedules s
                    JOIN employees e ON s.EmployeeID = e.EmployeeID
                    WHERE s.AvailabilityStatus = 'available'";
$schedules_result = mysqli_query($con, $schedules_query);

// Fetch employees for dropdown
$employees_query = "SELECT EmployeeID, Name FROM employees";
$employees_result = mysqli_query($con, $employees_query);

if (isset($_POST['add_schedule'])) {
    $employee_id = mysqli_real_escape_string($con, $_POST['employee_id']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $start_time = mysqli_real_escape_string($con, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($con, $_POST['end_time']);
    $availability_status = mysqli_real_escape_string($con, $_POST['availability_status']);

    do {
        $schedule_id = rand(500, 1000);
        $check_query = "SELECT * FROM schedules WHERE ScheduleID = '$schedule_id'";
        $check_result = mysqli_query($con, $check_query);
    } while (mysqli_num_rows($check_result) > 0);

    $query = "INSERT INTO schedules (ScheduleID, EmployeeID, Date, StartTime, EndTime, AvailabilityStatus) 
              VALUES ('$schedule_id', '$employee_id', '$date', '$start_time', '$end_time', '$availability_status')";
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Schedule added successfully'); window.location.href='admin.php?page=schedules';</script>";
    } else {
        echo "<script>alert('Error adding schedule');</script>";
    }
}

// Delete schedule logic
if (isset($_GET['delete'])) {
    $schedule_id = mysqli_real_escape_string($con, $_GET['delete']);
    $delete_query = "DELETE FROM schedules WHERE ScheduleID = '$schedule_id'";

    if (mysqli_query($con, $delete_query)) {
        echo "<script>alert('Schedule deleted successfully'); window.location.href='admin.php?page=schedules';</script>";
    } else {
        echo "<script>alert('Error deleting schedule: " . mysqli_error($con) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedules Management</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <h2>Manage Schedules</h2>

    <!-- Add Schedule Form -->
    <h3>Add Schedule</h3>
    <form method="POST">
        <label for="employee_id">Employee:</label>
        <select name="employee_id" required>
            <?php while ($employee = mysqli_fetch_assoc($employees_result)) { ?>
                <option value="<?php echo $employee['EmployeeID']; ?>"><?php echo $employee['Name']; ?></option>
            <?php } ?>
        </select>
        
        <label for="date">Date:</label>
        <input type="date" name="date" required>
        
        <label for="start_time">Start Time:</label>
        <input type="time" name="start_time" required>
        
        <label for="end_time">End Time:</label>
        <input type="time" name="end_time" required>
        
        <label for="availability_status">Availability Status:</label>
        <input type="text" name="availability_status" required>
        
        <button type="submit" name="add_schedule">Add Schedule</button>
    </form>

    <!-- Schedule Table -->
    <h3>Current Schedules</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Schedule ID</th>
                <th>Employee Name</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Availability Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($schedule = mysqli_fetch_assoc($schedules_result)) { ?>
                <tr>
                    <td><?php echo $schedule['ScheduleID']; ?></td>
                    <td><?php echo $schedule['EmployeeName']; ?></td>
                    <td><?php echo $schedule['Date']; ?></td>
                    <td><?php echo $schedule['StartTime']; ?></td>
                    <td><?php echo $schedule['EndTime']; ?></td>
                    <td><?php echo $schedule['AvailabilityStatus']; ?></td>
                    <td>
                        <a href="admin_edit_schedule.php?id=<?php echo $schedule['ScheduleID']; ?>">Edit</a>
                        <a href="?delete=<?php echo $schedule['ScheduleID']; ?>" onclick="return confirm('Are you sure you want to delete this schedule?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
