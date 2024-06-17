<?php
include 'config.php';

$conn->query("SET FOREIGN_KEY_CHECKS = 0");

// Get the appointment ID from the URL parameter
$pt_id = $_GET['id'];


// Delete the appointment from the database
$delete ="DELETE FROM appointments WHERE APTM_ID = '$pt_id'";

?>

<script>
    confirmDelete();
    
    function confirmDelete() {
        if (confirm("Are you sure you want to delete this appointment?")) {
            <?php $conn->query($delete); $conn->query("SET FOREIGN_KEY_CHECKS = 1"); $conn->close(); ?>
            window.location.href = "appointments.php";
        } else 
        header("Location: appointments.php");
    }
</script>


