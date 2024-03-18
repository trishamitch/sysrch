<?php
include "db_conn.php";

if(isset($_POST["query"])) {
    $search = $_POST["query"];
    
    // Assuming idno, firstname, middlename, and lastname are the fields you want to search for
    $sql = "SELECT u.idno, u.fname, u.mname, u.lname, r.purpose, r.laboratory, r.reserved_datetime, r.remaining_session 
            FROM users u 
            LEFT JOIN reservation r ON u.id = r.user_id 
            WHERE u.idno = '$search'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error executing the query: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='search-result'>";
            echo "<div class='button-container'>";
            echo "<button class='delete-button' onclick='deleteUser()'><i class='fas fa-trash-alt'></i></button>";
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
            echo "<input type='text' value='" . $row["laboratory"] . "' readonly>";
            echo "</div>";
            echo "<div class='input-group'>";
            echo "<label>Date&Time</label>";
            echo "<input type='text' value='" . $row["reserved_datetime"] . "' readonly>";
            echo "<label>Remaining Session</label>";
            echo "<input type='text' value='" . $row["remaining_session"] . "' readonly>";
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
