<?php 
session_start(); 
include "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {
    // Function to validate input data
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Validate and sanitize input data
    $uname = validate($_POST['uname']);
    $password = validate($_POST['password']);

    if (empty($uname)) {
        $error = "User Name is required";
    } elseif (empty($password)) {
        $error = "Password is required";
    } else {
        $stmt_admin = $conn->prepare("SELECT * FROM admin WHERE uname = ?");
        $stmt_admin->bind_param("s", $uname);
        $stmt_admin->execute();
        $result_admin = $stmt_admin->get_result();

        if ($result_admin->num_rows === 1) {
            // Fetch admin data
            $row = $result_admin->fetch_assoc();
            // Verify password
            if ($password === $row['password']) { // Compare plain text passwords for admin
                // Passwords match, set session variables and redirect to admin home
                $_SESSION['uname'] = $row['uname'];
                $_SESSION['id'] = $row['id'];
                header("Location: admin_home.php");
                exit();
            } else {
                // Incorrect password
                $error = "Incorrect password";
            }
        } else {
            // No user, admin, or staff found with the provided username
            $error = "Incorrect username or password";
        } 
    }
} 
?>

<!DOCTYPE html>
<html>
<head>
    <title>ADMIN LOGIN</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
</head>
<body>
    <div class="title">
        <a href="index.php"><i class="fas fa-arrow-left"></i><a>
        CCS SIT-IN MONITORING SYSTEM
    </div>   
     
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2>ADMIN LOGIN</h2>
        <?php if (!empty($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <label>User Name</label>
        <input type="text" name="uname" placeholder="User Name"><br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password">
        <div class="center">
            <a href="forgotpass.php" style="color: #a759f5">Forgot the Password?</a>
        </div>
        <br>
        <button type="submit">Login</button>
        <br><br><br>
        <div class="links" style="color: #a759f5">
            Don't have an account? <a href="register.php" style="color:#a759f5">Sign Up</a>
        </div>
    </form>
</body>
</html>
