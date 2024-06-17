<?php
session_start();
include 'config.php';
include 'return.php';
// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT d.*, s.Specialization 
        FROM doctors d 
        INNER JOIN specializations s ON d.Spec_ID = s.Spec_ID";
$result = $conn->query($sql);

// Check if query is successful 
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Doctors</title>
    <style>
        header{
            background: url(assets/img.jpg) no-repeat center fixed; 
            background-size: cover;
        }
        body {
            font-family: Arial, sans-serif;
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
        .adddoctor {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .adddoctor:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Doctors</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>License Number</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Fee</th>
            <th>Specialization</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['Doctor_ID'] ?></td>
            <td><?= $row['D_FName'] ?></td>
            <td><?= $row['D_LName'] ?></td>
            <td><?= $row['D_LicenseNum'] ?></td>
            <td><?= $row['D_CNum'] ?></td>
            <td><?= $row['D_Email'] ?></td>
            <td><?= $row['D_Fee'] ?></td>
            <td><?= $row['Specialization'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="addrecords/add_doctor.php" class="adddoctor">Add Doctor</a>
    <?php
    $conn->close();
    ?>
</body>
</html>