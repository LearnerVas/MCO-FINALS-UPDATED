<?php
include 'config.php';

// Get the appointment ID and new status from the form submission
$appointment_id = $_POST['appointment_id'];
$new_status = $_POST['status'];

// Update the appointment status in the database
$sql = "UPDATE appointments SET APTM_Status = '$new_status' WHERE APTM_ID = '$appointment_id'";
if ($conn->query($sql) === TRUE) {
    echo "Appointment status updated successfully!";
    header('Location: appointments.php');
} else {
    echo "Error updating appointment status: " . $conn->error;
}

// Close the database connection
$conn->close();