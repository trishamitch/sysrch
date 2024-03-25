<?php
include "db_conn.php";

// Check if form is submitted and a user ID is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $userId = $_POST["id"];
    
    // Delete associated reservations
    $sql_delete_reservations = "DELETE FROM reservations WHERE user_id = '$userId'";
    if ($conn->query($sql_delete_reservations) === TRUE) {
        // Then delete the user
        $sql_delete_user = "DELETE FROM users WHERE idno = '$userId'";
        if ($conn->query($sql_delete_user) === TRUE) {
            echo "User deleted successfully";
        } else {
            echo "Error deleting user: " . $conn->error;
        }
    } else {
        echo "Error deleting reservations: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete User</title>
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
        <a href="delete_user.php" class="active">
            <i class="fa fa-trash"></i>
            <span>Delete</span>
        </a>
        <a href="view_sitin.php">
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
        <h2>List of Students</h2>
        <div class="table-class">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_fetch_users = "SELECT idno, CONCAT(fname, ' ', lname) AS name, uname FROM users";
                    $result_users = $conn->query($sql_fetch_users);
                    if ($result_users && $result_users->num_rows > 0) {
                        while($row = $result_users->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["idno"] . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["uname"] . "</td>";
                            echo "<td><form method='post' onsubmit='return confirmDelete()'><input type='hidden' name='id' value='" . $row["idno"] . "'><button type='submit'>Delete</button></form></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No users found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this user?");
        }
    </script>
</body>
</html>
