<?php
include "db_conn.php";

if(isset($_POST["query"])) {
    $search = $_POST["query"];
    
    // Assuming idno, firstname, middlename, and lastname are the fields you want to search for
    $sql = "SELECT u.idno, u.fname, u.mname, u.lname, r.purpose, r.room, r.date, r.time 
            FROM users u 
            LEFT JOIN reservations r ON u.id = r.user_id 
            WHERE u.idno = '$search'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error executing the query: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='search-result'>";
            echo "<div class='button-container'>";
            echo "<button class='decline-button' onclick='declineUser()'>Decline</button>";
            echo "<button class='sitin-button' onclick='viewUser()'>Accept</button>";
            echo "</div>"; // close button-container
            echo "<div class='user-info'>";
            echo "<div class='input-group'>";
            echo "<label>ID No</label>";
            echo "<input type='text' value='" . $row["idno"] . "' readonly>";
            echo "</div>";
            echo "<div class='input-group'>";
            echo "<label>Name</label>";
            echo "<input type='text' value='" . $row["fname"] . " " . $row["mname"] . " " . $row["lname"] . "' readonly>";
            echo "</div>";
            echo "<br>";
            echo "<div class='input-group'>";
            echo "<label>Laboratory</label>";
            echo "<input type='text' value='" . $row["room"] . "' readonly>";
            echo "</div>";
            echo "<div class='input-group'>";
            echo "<label>Purpose</label>";
            echo "<input type='text' value='" . $row["purpose"] . "' readonly>";
            echo "</div>";
            echo "<div class='input-group'>";
            echo "<label>Date</label>";
            echo "<input type='text' value='" . $row["date"] . "' readonly>";
            echo "</div>";
            echo "<div class='input-group'>";
            echo "<label>Time</label>";
            echo "<input type='text' value='" . $row["time"] . "' readonly>";
            echo "</div>";
            echo "</div>"; // close user-info
            echo "</div>"; // close search-result
        }
    } else {
        echo "No results found";
    }
} else {
    echo "No search query provided";
}
?>
