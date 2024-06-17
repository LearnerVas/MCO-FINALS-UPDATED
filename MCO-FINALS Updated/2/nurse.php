<?php
session_start();
include 'config.php';
include 'return.php';;

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT n.*, s.Specialization 
        FROM nurses n 
        INNER JOIN specializations s ON n.Spec_ID = s.Spec_ID";
$result = $conn->query($sql);

// Check if query is successful
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nurses</title>
    <style>
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
        .addnurse {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .addnurse:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Nurses</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>License Number</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Specialization</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['Nurse_ID'] ?></td>
            <td><?= $row['N_FName'] ?></td>
            <td><?= $row['N_LName'] ?></td>
            <td><?= $row['N_LicNumber'] ?></td>
            <td><?= $row['N_CNum'] ?></td>
            <td><?= $row['N_Email'] ?></td>
            <td><?= $row['Specialization'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="addrecords/add_nurse.php" class="addnurse">Add Nurse</a>
    <?php
    $conn->close();
    ?>
</body>
</html>
