<!DOCTYPE html>
<html lang="en">
<head>
<title>Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <style> 
html { 
  background: url(assets/img.jpg) no-repeat center fixed; 
  background-size: cover;
}

body { 
  color: white; 
}
</style>
</head>
<body>
<div class="container">
<nav class="topnav">
        <div class="logo"><img src="assets/logo.png"
        style="width: 150px; height: 150px";></div>
        <input type="text" class="search-bar" placeholder="Search...">
                <div class="profile">
                <span>Izza Mariel</span>
                <img src="assets/admin.png" alt="Profile Picture">
                    </div>
                </nav>
        <div class="sidebar">
            <h2>Dashboard</h2>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="appointments.php">Appointments</a></li>
                <li><a href="patient.php">Patients</a></li>
                <!-- Staff option with dropdown -->
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="staffDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Staff</a>
            <div class="dropdown-menu" aria-labelledby="staffDropdown">
            <a class="dropdown-item" href="nurse.php">Nurses</a>
            <a class="dropdown-item" href="doctors.php">Doctors</a>

</li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
</body>
</html>