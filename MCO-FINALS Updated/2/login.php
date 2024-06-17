<?php
session_start();
include 'config.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $username = $_POST['username'];
        $password = $_POST['password'];
        
        
    $stmt = $conn->prepare("SELECT User_ID, User_UName, User_Pword FROM adminstaff WHERE User_UName = ? AND User_PWord = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['message'] = "Logged in successfully";
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }

    $stmt->close();
}
?>

<!-- HTML form -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <style> 
html { 
  background: url(assets/img.jpg) no-repeat center fixed; 
  background-size: cover;
}
</style>
</head>
<body>
    <div class="outer-container">

        <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <div class="rectangle-container">
            <div class="logo"><img src=assets/logo.png alt="Logo"> <!--class for image so it will not ruin the login container -->
            <div class="container">
            <div class="login-container">
                
                <form method="post" action="login.php">
                    <div class="input-group"> <!--This is for you to input your username and password-->
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="input-group"> <!--This is also for you to input your username and password-->
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit">Login</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
