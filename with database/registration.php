<?php
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idno = $_POST['idno'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $uname = $_POST['uname'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if (empty($idno) || empty($fname) || empty($lname) || empty($age) || empty($gender) || empty($number) || empty($address) || empty($uname) || empty($password) || empty($cpassword)) {
        header("Location: register.php?error=All fields are required");
        exit();
    } elseif ($password !== $cpassword) {
        header("Location: register.php?error=Password does not match");
        exit();
    } else {
        // Hash the password before storing it in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind the statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO users (idno, fname, mname, lname, age, gender, number, address, uname, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $idno, $fname, $mname, $lname, $age, $gender, $number, $address, $uname, $hashed_password);

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: index.php?success=Your account has been created successfully");
            exit();
        } else {
            // Redirect with an error message
            header("Location: register.php?error=Registration failed");
            exit();
        }
    }
} else {
    header("Location: register.php");
    exit();
}
?>
