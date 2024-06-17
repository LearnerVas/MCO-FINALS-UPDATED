<?php
include 'config.php';
include 'return.php';;

$stmt = $conn->prepare("SELECT 
                            a.APTM_ID, 
                            CONCAT(p.PT_FName, ' ', p.PT_LName) AS Patient, 
                            CONCAT(d.D_FName, ' ', d.D_LName) AS Doctor, 
                            CONCAT(n.N_FName, ' ', n.N_LName) AS Nurse, 
                            s.Serv_Title AS Service, 
                            a.APTM_Date, 
                            a.APTM_Status, 
                            u.User_UName AS AppointedBy
                        FROM 
                            appointments a
                        LEFT JOIN 
                            patient p ON a.PT_ID = p.PT_ID
                        LEFT JOIN 
                            doctors d ON a.Doctor_ID = d.Doctor_ID
                        LEFT JOIN 
                            nurses n ON a.Nurse_ID = n.Nurse_ID
                        LEFT JOIN 
                            services s ON a.Serv_ID = s.Serv_ID
                        LEFT JOIN 
                            adminstaff u ON a.User_ID = u.User_ID
                        WHERE APTM_Status ='Cancelled'");
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cancelled Appointments</title>
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
        .btn {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 12px;
        }
        .btn-return {
            position: absolute;
            top: 10px;
            left: 10px;
        }
        .link-container {
            margin-top: 20px;
        }
        .link-container a {
            margin-right: 15px;
            text-decoration: none;
            color: #007BFF;
        }
        .link-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <form action="dashboard.php" method="post">
        <button type="submit" class="btn btn-return">Return</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Nurse</th>
            <th>Service</th>
            <th>Date</th>
            <th>Status</th>
            <th>Appointed By</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['APTM_ID']; ?></td>
                <td><?php echo $row['Patient']; ?></td>
                <td><?php echo $row['Doctor']; ?></td>
                <td><?php echo $row['Nurse']; ?></td>
                <td><?php echo $row['Service']; ?></td>
                <td><?php echo $row['APTM_Date']; ?></td>
                <td><?php echo $row['APTM_Status']; ?></td>
                <td><?php echo $row['AppointedBy']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div class="link-container">
        <a href="add_appointment.php" class="btn">Add Appointments</a>
        <a href='completed_appointment.php'>Completed</a>
        <a href='cancelled_appointments.php'>Cancelled</a>
        <a href='pending_appointments.php'>Pending</a>
    </div>

    <?php
    // Close connection
    $conn->close();
    ?>
</body>
</html>
