<?php
include "db_conn.php";

if (isset($_POST['idno'],$_POST['fname'], $_POST['mname'], $_POST['lname'], $_POST['age'], $_POST['gender'], $_POST['number'], $_POST['address'], $_POST['uname'], $_POST['password'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $idno = validate($_POST['idno']);
    $fname = validate($_POST['fname']);
    $mname = validate($_POST['mname']);
    $lname = validate($_POST['lname']);
    $age = validate($_POST['age']);
    $gender = validate($_POST['gender']);
    $number = validate($_POST['number']);
    $address = validate($_POST['address']);
    $uname = validate($_POST['uname']);
    $password = validate($_POST['password']);
    $cpassword = validate($_POST['cpassword']);

    if (empty($idno) || empty($fname) || empty($mname) || empty($lname) || empty($age) || empty($gender) || empty($number) || empty($address) || empty($uname) || empty($password) || empty($cpassword)) {
        header("Location: register.php?error=All fields are required");
        exit();
    } elseif ($password !== $cpassword) {
        header("Location: register.php?error=Password does not match");
        exit();
    } else {
        // Insert the password as plaintext into the database
        $sql = "INSERT INTO users (idno,fname, mname, lname, age, gender, number, address, uname, password) 
               VALUES ('$idno','$fname', '$mname', '$lname', '$age', '$gender', '$number', '$address', '$uname', '$password')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            header("Location: index.php?success=Your account has been created successfully");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            exit();
        }
    }
} else {
    header("Location: register.php");
    exit();
}


?>