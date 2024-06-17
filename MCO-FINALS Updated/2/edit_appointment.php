<?php
session_start();
include 'config.php';
include 'return.php';
// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get the appointment ID from the URL parameter
$appointment_id = $_GET['id'];

// Use prepared statement to retrieve the appointment details
$stmt = $conn->prepare("SELECT * FROM appointments WHERE APTM_ID = ?");
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Check if the appointment exists
if (!$row) {
    echo "Appointment not found.";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Appointment</title>
    <style>
        header{
            background: url(assets/img.jpg) no-repeat center fixed; 
            background-size: cover;
        }
        body {
            font-family: Arial, sans-serif;
        }
        form {
            margin: 20px 0;
        }
        label, select, input {
            display: block;
            margin: 10px 0;
        }
        select, input {
            padding: 5px;
            width: 200px;
        }
        .submit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Edit Appointment</h1>
    <form action="update_appointment.php" method="post">
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="<?= $row['APTM_Status'] ?>"><?= $row['APTM_Status'] ?></option>
            <option value="Completed">Completed</option>
            <option value="Cancelled">Cancelled</option>
            <option value="Delayed">Delayed</option>
        </select>
        <br>
        <input type="hidden" name="appointment_id" value="<?= $appointment_id ?>">
        <input type="submit" value="Update Status" class="submit-btn">
    </form>
    <?php
    // Close connection
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
