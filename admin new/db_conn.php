<?php
$sname = "localhost";
$uname = "root"; // Corrected variable name
$password = "";
$db_name = "user_db2";

$conn = new mysqli($sname, $uname, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
