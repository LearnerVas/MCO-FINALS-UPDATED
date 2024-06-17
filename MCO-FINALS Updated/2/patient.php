<?php
session_start();
include 'config.php';
include 'return.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Query to select all patients
$sql = "SELECT * FROM patient";
$result = $conn->query($sql);

// Check if query is successful
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Patients</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background: url(assets/img.jpg) no-repeat center fixed;
            background-size: cover;
            height: 200px;
            text-align: center;
            color: white;
            padding: 60px 0;
        }
        .content {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .addpatient {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .addpatient:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <h1>Patient Records</h1>
    </header>
    <div class="content">
        <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>Age</th>
                <th>Phone Number</th>
                <th>Email</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['PT_ID'] ?></td>
                    <td><?= $row['PT_FName'] ?></td>
                    <td><?= $row['PT_LName'] ?></td>
                    <td><?= $row['PT_Address'] ?></td>
                    <td><?= $row['PT_Age'] ?></td>
                    <td><?= $row['PT_CNumber'] ?></td>
                    <td><?= $row['PT_Email'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <a href="add_patient.php" class="addpatient">Add Patient</a>
    </div>
    <?php
    // Close connection
    $conn->close();
    ?>
</body>
</html>

