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
        // Prepare SQL statement to retrieve user by username from users table
        $stmt_user = $conn->prepare("SELECT * FROM users WHERE uname = ?");
        $stmt_user->bind_param("s", $uname);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();

        // Prepare SQL statement to retrieve admin by username from admin table
        $stmt_admin = $conn->prepare("SELECT * FROM admin WHERE uname = ?");
        $stmt_admin->bind_param("s", $uname);
        $stmt_admin->execute();
        $result_admin = $stmt_admin->get_result();

        // Prepare SQL statement to retrieve staff by username from staff table
        $stmt_staff = $conn->prepare("SELECT * FROM staff WHERE uname = ?");
        $stmt_staff->bind_param("s", $uname);
        $stmt_staff->execute();
        $result_staff = $stmt_staff->get_result();

        if ($result_user->num_rows === 1) {
            // Fetch user data
            $row = $result_user->fetch_assoc();
            // Verify password
            if (password_verify($password, $row['password'])) { // Compare hashed password
                // Passwords match, set session variables and redirect to user home
                $_SESSION['uname'] = $row['uname'];
                $_SESSION['fname'] = $row['fname'];
                $_SESSION['id'] = $row['id'];
                header("Location: home.php");
                exit();
            } else {
                $error = "Incorrect username or password";
            }
        } elseif ($result_admin->num_rows === 1) {
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
        } elseif ($result_staff->num_rows === 1) {
            // Fetch staff data
            $row = $result_staff->fetch_assoc();
            // Verify password
            if (password_verify($password, $row['password'])) { // Compare hashed password
                // Passwords match, set session variables and redirect to staff home
                $_SESSION['uname'] = $row['uname'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                header("Location: staff_home.php");
                exit();
            } else {
                $error = "Incorrect username or password";
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
    <title>LOGIN</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>CCS SIT-IN MONITORING SYSTEM</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2>LOGIN</h2>
        <?php if (!empty($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <label>User Name</label>
        <input type="text" name="uname" placeholder="User Name"><br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password">
        <div class="center">
            <a href="forgotpass.php" style="color: #fff">Forgot the Password?</a>
        </div>
        <br>
        <button type="submit">Login</button>
        <br><br><br>
        <div class="links" style="color: #fff">
            Don't have an account? <a href="register.php" style="color:#fff">Sign Up</a>
        </div>
    </form>
</body>
</html>
