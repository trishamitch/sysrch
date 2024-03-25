<?php
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reservation_id'])) {
    $reservation_id = $_POST['reservation_id'];

    // Fetch current sessions remaining
    $sql_fetch = "SELECT sessions_remaining, timeout_date FROM reservations WHERE id = ?";
    $stmt_fetch = $conn->prepare($sql_fetch);
    $stmt_fetch->bind_param("i", $reservation_id);
    $stmt_fetch->execute();
    $result_fetch = $stmt_fetch->get_result();
    
    if ($result_fetch->num_rows == 1) {
        $row = $result_fetch->fetch_assoc();
        $sessions_remaining = $row['sessions_remaining'];
        $timeout_date = $row['timeout_date'];

        if (!$timeout_date && $sessions_remaining > 0) { // Check if timeout has not occurred and sessions remaining is greater than 0
            // Decrement sessions remaining
            $sessions_remaining--;

            // Update sessions remaining and set timeout date in the database
            $sql_update = "UPDATE reservations SET sessions_remaining = ?, timeout_date = NOW() WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ii", $sessions_remaining, $reservation_id);
            $stmt_update->execute();

            echo $sessions_remaining; // Send updated sessions remaining back to the client
        } else {
            echo "0"; // If timeout has already occurred or sessions remaining is 0, return 0
        }
    } else {
        echo "Error fetching reservation"; // Handle error if reservation not found
    }

    // Close statements
    $stmt_fetch->close();
    $stmt_update->close();
    // Close database connection
    $conn->close();
} else {
    echo "Invalid request";
}
?>
