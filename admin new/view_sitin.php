<?php
include "db_conn.php";

// Check if a date is provided
if (isset($_GET['date'])) {
    // Get the date from the URL
    $date = $_GET['date'];

    // Fetch reservations for the specified date
    $sql = "SELECT r.*, u.fname, u.lname, DATE(r.created_at) AS reservation_date, TIME(r.created_at) AS reservation_time FROM reservations r JOIN users u ON r.user_id = u.idno WHERE DATE(r.created_at) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // If no date is provided, set a default date
    $date = date("Y-m-d");
    // Fetch reservations for the current date
    $sql = "SELECT r.*, u.fname, u.lname, DATE(r.created_at) AS reservation_date, TIME(r.created_at) AS reservation_time FROM reservations r JOIN users u ON r.user_id = u.idno WHERE DATE(r.created_at) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Sitin Records</title>
    <link rel="stylesheet" type="text/css" href="style_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <input type="checkbox" id="check">
    <label for="check">
        <i class="fas fa-bars" id="btn"></i>
        <i class="fas fa-times" id="cancel"></i>
    </label>
    <div class="sidebar">
        <header>Menu</header>
        <a href="admin_home.php">
            <i class="fas fa-search"></i>
            <span>Search</span>
        </a>
        <a href="delete_user.php">
            <i class="fa fa-trash"></i>
            <span>Delete</span>
        </a>
        <a href="view_sitin.php" class="active">
            <i class="fa fa-users"></i> 
            <span>View Sitin Records</span>
        </a>
        <a href="#">
            <i class="fas fa-chalkboard-teacher"></i> 
            <span>Generate Reports</span>
        </a>
        <a href="index.php">
            <i class="fas fa-sign-out-alt"></i>
            <span>Log Out</span>
        </a>
    </div>
    <div class="frame">
        <div class="view-table">
            <h2>View Sitin Records <br><?php echo $date; ?></h2>
            <form action="view_sitin.php" method="get">
                <label for="date">Select Date:</label>
                <input type="date" id="date" name="date">
                <button type="submit">View Records</button>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Purpose</th>
                        <th>Room</th>
                        <th>Sessions Remaining</th>
                        <th>Reservation Date</th>
                        <th>Reservation Time</th>
                        <th>Timeout Date</th> <!-- Added column for timeout date -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["user_id"] . "</td>";
                            echo "<td>" . $row["fname"] . " " . $row["lname"] . "</td>";
                            echo "<td>" . $row["purpose"] . "</td>";
                            echo "<td>" . $row["room"] . "</td>";
                            echo "<td id='sessions_remaining_" . $row['id'] . "'>" . $row["sessions_remaining"] . "</td>";
                            echo "<td>" . $row["reservation_date"] . "</td>";
                            echo "<td>" . $row["reservation_time"] . "</td>";
                            echo "<td>" . ($row["timeout_date"] ? $row["timeout_date"] : "Not timed out") . "</td>"; // Display timeout date or "Not timed out"
                            if (!$row["timeout_date"]) { // Check if timeout has not occurred
                                echo "<td><button onclick='timeout(" . $row['id'] . ")'>Timeout</button></td>"; // Pass reservation ID to timeout function
                            } else {
                                echo "<td></td>"; // Display empty cell if timeout has occurred
                            }
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function timeout(reservationId) {
            if (confirm("Are you sure you want to timeout this reservation?")) {
                // AJAX request to update sessions remaining
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "reduce_session.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Update sessions remaining in the table
                        document.getElementById("sessions_remaining_" + reservationId).innerText = xhr.responseText;
                    }
                };
                xhr.send("reservation_id=" + reservationId);
            }
        }
    </script>
</body>
</html>
