<?php
session_start();
include "db_conn.php";

// Step 1: Check if the username is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['uname'])) {
    $uname = $_POST['uname'];
    
    // Perform necessary validation on username

    // Check if the username exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE uname = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION['uname'] = $uname; // Store username in session
        $show_reset_form = true; // Proceed to next step (show password reset form)
    } else {
        $error = "Username not found";
    }
}

// Step 2: Check if the reset password form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_password'])) {
    // Assuming you've implemented proper password strength validation
    
    // Retrieve new password and confirm password
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Perform necessary validation on passwords
    
    // Check if new password matches the confirm password
    if ($new_password === $confirm_password) {
        // Update the user's password in the database
        $uname = $_SESSION['uname']; // Correct session variable name
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE uname = ?");
        $stmt->bind_param("ss", $hashed_password, $uname);
        $stmt->execute();

        // Password updated successfully, you can redirect the user to login page or show a success message
        $password_reset_success = true;
        unset($_SESSION['uname']); // Clear username from session
    } else {
        $error = "Passwords do not match";
        $show_reset_form = true; // Show password reset form again
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Forgot Password</h1>
    <?php if (isset($error)) { ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>
    
    <?php if (isset($password_reset_success)) { ?>
        <p class="success">Password reset successfully. </p><br><a href="index.php"><button>Login</button></a>
    <?php } elseif (isset($show_reset_form) && $show_reset_form) { ?>
        <!-- Step 2: Password reset form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label>New Password</label>
            <input type="password" name="new_password" placeholder="New Password"><br>
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" placeholder="Confirm Password"><br>
            <button type="submit">Reset Password</button>
        </form>
    <?php } else { ?>
        <!-- Step 1: Username verification form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label>Username</label>
            <input type="text" name="uname" placeholder="Username"><br>
            <button type="submit">Verify Username</button>
        </form>
    <?php } ?>
</body>
</html>
