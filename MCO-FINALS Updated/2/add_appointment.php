<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient = $_POST['patient'];
    $doctor = $_POST['doctor'];
    $nurse = $_POST['nurse'];
    $service = $_POST['service'];
    $date = $_POST['date'];
    $status = 'Pending';
    $admin = $_POST['admin'];

    $stmt = $conn->prepare("INSERT INTO appointments (PT_ID, Doctor_ID, Nurse_ID, Serv_ID, APTM_Date, APTM_Status, User_ID) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiissi", $patient, $doctor, $nurse, $service, $date, $status, $admin);
    $stmt->execute();

    if (!$stmt->error) {
        echo "<script>alert('Added successfully');</script>";
        header("Location: appointments.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Patient from database
$pt = "SELECT PT_ID, PT_FName, PT_LName FROM patient";
$presult = $conn->query($pt);
$ptnt = array();
while ($row = $presult->fetch_assoc()) {
    $ptnt[$row['PT_ID']] = $row['PT_FName'] . ' ' . $row['PT_LName'];
}

// Doctor from database
$dc = "SELECT Doctor_ID, D_FName, D_LName FROM doctors";
$dresult = $conn->query($dc);
$dctr = array();
while ($row = $dresult->fetch_assoc()) {
    $dctr[$row['Doctor_ID']] = $row['D_FName'] . ' ' . $row['D_LName'];
}

// Nurse from database
$ns = "SELECT Nurse_ID, N_FName, N_LName FROM nurses";
$nresult = $conn->query($ns);
$nrss = array();
while ($row = $nresult->fetch_assoc()) {
    $nrss[$row['Nurse_ID']] = $row['N_FName'] . ' ' . $row['N_LName'];
}

// Services from database
$sr = "SELECT Serv_ID, Serv_Title FROM services";
$sresult = $conn->query($sr);
$srvs = array();
while ($row = $sresult->fetch_assoc()) {
    $srvs[$row['Serv_ID']] = $row['Serv_Title'];
}

// Admin appointee from database
$ap = "SELECT User_ID, User_FName, User_LName FROM adminstaff";
$aresult = $conn->query($ap);
$admn = array();
while ($row = $aresult->fetch_assoc()) {
    $admn[$row['User_ID']] = $row['User_FName'] . ' ' . $row['User_LName'];
}
?>

<!-- HTML form with internal CSS -->
<form action="add_appointment.php" method="post">

    <style>
        /* General Styles */
        html { 
            background: url(assets/img.jpg) no-repeat center fixed; 
            background-size: cover;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; 
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"],
        select {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        input::placeholder,
        select {
            color: #999;
        }

        h2 {
            text-align: center;
            color: #333;
        }
    </style>

    <h2>Add Appointment</h2>

    <select name="patient" required>
        <option value="">--Patient--</option>
        <?php foreach ($ptnt as $id => $name) { ?>
            <option value="<?php echo $id ?>"><?php echo $name ?></option>
        <?php } ?>
    </select>

    <select name="doctor" required>
        <option value="">--Doctor--</option>
        <?php foreach ($dctr as $id => $name) { ?>
            <option value="<?php echo $id ?>"><?php echo $name ?></option>
        <?php } ?>
    </select>

    <select name="nurse" required>
        <option value="">--Nurse--</option>
        <?php foreach ($nrss as $id => $name) { ?>
            <option value="<?php echo $id ?>"><?php echo $name ?></option>
        <?php } ?>
    </select>

    <select name="service" required>
        <option value="">--Service--</option>
        <?php foreach ($srvs as $id => $name) { ?>
            <option value="<?php echo $id ?>"><?php echo $name ?></option>
        <?php } ?>
    </select>

    <input type="date" name="date" required>

    <select name="admin" required>  
        <option value="">--Appointed by:--</option>
        <?php foreach ($admn as $id => $name) { ?>
            <option value="<?php echo $id ?>"><?php echo $name ?></option>
        <?php } ?>
    </select>

    <button type="submit">Add</button>

</form>
