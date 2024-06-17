<?php
session_start();
include 'config.php';
include 'sb&hd.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

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
                        WHERE APTM_Status = 'Pending'
                        ORDER BY 
                            a.APTM_Date ASC 
                        LIMIT 5 ");
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        header{
            background: url(assets/img.jpg) no-repeat center fixed; 
            background-size: cover;
        }
        body {
            font-family: Arial, sans-serif;
        }
        .c-wrapper {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
        }
        .counter {
            text-align: center;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 30%;
        }
        .counter h3 {
            margin: 0;
            font-size: 2em;
        }
        .counter p {
            margin: 5px 0 0 0;
            font-size: 1em;
        }
        .main-content {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
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
    </style>
</head>
<body>
    <div class="c-wrapper">
        <div class="counter">
            <?php
                $patient_query ="SELECT count(*) FROM patient";
                $stmt = $conn->prepare($patient_query);
                $stmt->execute();
                $stmt->bind_result($patient);
                $stmt->fetch();
                $stmt->close();
            ?>
            <h3 class="p-counter"><span><?php echo $patient;?></span></h3>
            <p class="p-text">Patients</p>
        </div>

        <div class="counter">
            <?php
                $apmt_query ="SELECT count(*) FROM appointments";
                $stmt = $conn->prepare($apmt_query);
                $stmt->execute();
                $stmt->bind_result($appointment);
                $stmt->fetch();
                $stmt->close();
            ?>
            <h3 class="a-counter"><span><?php echo $appointment;?></span></h3>
            <p class="a-text">Appointments</p>
        </div>

        <div class="counter">
            <?php
                $dc_query ="SELECT count(*) FROM doctors";
                $stmt = $conn->prepare($dc_query);
                $stmt->execute();
                $stmt->bind_result($doctor);
                $stmt->fetch();
                $stmt->close();

                $nrss_query ="SELECT count(*) FROM nurses";
                $stmt = $conn->prepare($nrss_query);
                $stmt->execute();
                $stmt->bind_result($nurse);
                $stmt->fetch();
                $stmt->close();

                $total_count = $doctor + $nurse;
            ?>
            <h3 class="p-counter"><span><?php echo $total_count;?></span></h3>
            <p class="p-text">Staff</p>
        </div>
    </div>

    <div class="main-content">
        <h1>Latest Appointments</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Nurse</th>
                <th>Service</th>
                <th>Date</th>
                <th>Status</th>
                <th>Appointed by:</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
               <td><?= $row['APTM_ID'] ?></td>
               <td><?= $row['Patient'] ?></td>
               <td><?= $row['Doctor'] ?></td>
               <td><?= $row['Nurse'] ?></td>
               <td><?= $row['Service'] ?></td>
               <td><?= $row['APTM_Date'] ?></td>
               <td><?= $row['APTM_Status'] ?></td>
               <td><?= $row['AppointedBy'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <?php
    $conn->close();
    ?>
</body>
</html>
