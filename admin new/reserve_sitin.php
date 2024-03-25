<?php
// Include database connection
include "db_conn.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user_id = $_POST['userId']; // Update variable name
    $purpose = $_POST['purpose'];
    $labRoom = $_POST['labRoom'];

    // Check if the user has remaining sessions
    $sql_sessions = "SELECT COUNT(*) AS total_sessions FROM reservations WHERE user_id = ?";
    $stmt_sessions = $conn->prepare($sql_sessions);
    $stmt_sessions->bind_param("i", $user_id);
    $stmt_sessions->execute();
    $result_sessions = $stmt_sessions->get_result();
    $total_sessions = 0;

    if ($result_sessions->num_rows > 0) {
        $row_sessions = $result_sessions->fetch_assoc();
        $total_sessions = $row_sessions["total_sessions"];
    }

    // Check if user has remaining sessions
    if ($total_sessions < 30) { // Assuming maximum allowed sessions is 30
        // Insert reservation data into the database
        $sql = "INSERT INTO reservations (user_id, purpose, room, sessions, sessions_remaining) VALUES (?, ?, ?, 1, 30 - ?)"; // Insert with 1 session and update sessions_remaining
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $user_id, $purpose, $labRoom, $total_sessions);
        
        if ($stmt->execute()) {
            // Reservation successful
            echo "Reservation successful";
        } else {
            // Reservation failed
            echo "Error: " . $conn->error;
        }

        // Close statements
        $stmt->close();
    } else {
        // User has reached maximum sessions
        echo "User has reached maximum sessions";
    }

    // Close database connection
    $conn->close();
} else {
    // If the form is not submitted properly
    echo "Form submission failed";
}
?>
