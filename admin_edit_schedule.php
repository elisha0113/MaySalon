<?php
session_start();
include 'setup.php';

// Check if admin is logged in.
if (!isset($_SESSION["AdminID"])) {
    header("Location: admin_login.php");
    exit();
}

$schedule_id = mysqli_real_escape_string($con, $_GET['id']);
$schedule_query = "SELECT * FROM schedules WHERE ScheduleID='$schedule_id'";
$schedule_result = mysqli_query($con, $schedule_query);
$schedule = mysqli_fetch_assoc($schedule_result);

// Fetch employees for dropdown
$employees_query = "SELECT EmployeeID, Name FROM employees";
$employees_result = mysqli_query($con, $employees_query);

if (isset($_POST['update_schedule'])) {
    $employee_id = mysqli_real_escape_string($con, $_POST['employee_id']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $start_time = mysqli_real_escape_string($con, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($con, $_POST['end_time']);
    $availability_status = mysqli_real_escape_string($con, $_POST['availability_status']);

    $query = "UPDATE schedules SET EmployeeID='$employee_id', Date='$date', StartTime='$start_time', 
              EndTime='$end_time', AvailabilityStatus='$availability_status' WHERE ScheduleID='$schedule_id'";
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Schedule updated successfully'); window.location.href='admin.php?page=schedules';</script>";
    } else {
        echo "<script>alert('Error updating schedule');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Schedule</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <h2>Edit Schedule</h2>
    <form method="POST">
        <label for="employee_id">Employee:</label>
        <select name="employee_id" required>
            <?php while ($employee = mysqli_fetch_assoc($employees_result)) { ?>
                <option value="<?php echo $employee['EmployeeID']; ?>" <?php if ($employee['EmployeeID'] == $schedule['EmployeeID']) echo 'selected'; ?>>
                    <?php echo $employee['Name']; ?>
                </option>
            <?php } ?>
        </select>
        
        <label for="date">Date:</label>
        <input type="date" name="date" value="<?php echo $schedule['Date']; ?>" required>
        
        <label for="start_time">Start Time:</label>
        <input type="time" name="start_time" value="<?php echo $schedule['StartTime']; ?>" required>
        
        <label for="end_time">End Time:</label>
        <input type="time" name="end_time" value="<?php echo $schedule['EndTime']; ?>" required>
        
        <label for="availability_status">Availability Status:</label>
        <input type="text" name="availability_status" value="<?php echo $schedule['AvailabilityStatus']; ?>" required>
        
        <button type="submit" name="update_schedule">Update Schedule</button>
    </form>
    <a href="admin.php?page=schedules">
    <button type="button">Back to Admin Page</button>
</a>
</body>
</html>
