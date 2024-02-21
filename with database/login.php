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
        header("Location: index.php?error=User Name is required");
        exit();
    } elseif (empty($password)) {
        header("Location: index.php?error=Password is required");
        exit();
    } else {
        // Prepare SQL statement to retrieve user by username
        $stmt = $conn->prepare("SELECT * FROM users WHERE uname = ?");
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Fetch user data
            $row = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $row['password'])) {
                // Passwords match, set session variables and redirect to home.php
                $_SESSION['uname'] = $row['uname'];
                $_SESSION['fname'] = $row['fname'];
                $_SESSION['id'] = $row['id'];
                header("Location: home.php");
                exit();
            } else {
                // Incorrect password
                header("Location: index.php?error=Incorrect password");
                exit();
            }
        } else {
            // No user found with the provided username
            header("Location: index.php?error=Incorrect username");
            exit();
        }
    }
} else {
    // Redirect to index.php if username or password is not set
    header("Location: index.php");
    exit();
}
?>
