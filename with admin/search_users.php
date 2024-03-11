<?php
include "db_conn.php";

if(isset($_POST["query"])) {
    $search = $_POST["query"];
    
    // Assuming idno, fname, mname, and lname are the fields you want to search for
    $sql = "SELECT idno, fname, mname, lname FROM users WHERE idno LIKE '%$search%'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error executing the query: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID No</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Action</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["idno"] . "</td>";
            echo "<td>" . $row["fname"] . "</td>";
            echo "<td>" . $row["mname"] . "</td>";
            echo "<td>" . $row["lname"] . "</td>";
            echo "<td><button onclick='deleteUser(" . $row["idno"] . ")'>Delete</button></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No results found";
    }
} else {
    echo "No search query provided";
}
?>
