<?php
include "db_conn.php";

if(isset($_POST["id"])) {
    $userId = $_POST["id"];
    
    // Delete user from the database
    $sql = "DELETE FROM users WHERE idno = '$userId'";
    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
} else {
    echo "No user ID provided";
}
?>
