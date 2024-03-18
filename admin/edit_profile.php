<?php
session_start(); // Start the session
include "db_conn.php";

// Check if user is logged in and session variables are set
if (!isset($_SESSION['id']) || !isset($_SESSION['uname'])) {
    // Handle unauthorized access or redirect to login page
}

// Fetch user data from the database
$userData = array(); // Initialize empty array to store user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
    $_SESSION['gender'] = $userData['gender']; // Set $_SESSION['gender'] here
} else {
    // Handle error if user data is not found
    echo "Error: User data not found.";
    exit();
}

// Process form submission for updating user information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract the submitted data
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $number = $_POST['number'];
    $address = $_POST['address'];

    // Update the user information in the database
    $stmt_update = $conn->prepare("UPDATE users SET fname = ?, mname = ?, lname = ?, age = ?, gender = ?, number = ?, address = ? WHERE id = ?");
    $stmt_update->bind_param("sssssssi", $fname, $mname, $lname, $age, $gender, $number, $address, $_SESSION['id']);

    if ($stmt_update->execute()) {
        // Update session variable with the new first name
        $_SESSION['fname'] = $fname;

        // Redirect to the current page with success message
        header("Location: ".$_SERVER['PHP_SELF']."?edit_profile&success=User information updated successfully");
        exit();
    } else {
        // Handle error if update fails
        $error = "Error updating user information";
    }
}

// Define the $success variable before using it
$success = isset($_GET['success']) ? $_GET['success'] : "";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="home_style.css">
    <!-- Add a link to the FontAwesome CDN for icons -->
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
        <a href="home.php">
            <i class="fas fa-qrcode"></i>
            <span>Dashboard</span>
        </a>
        <a href="edit_profile.php" class="active">
            <i class="fas fa-user-edit"></i>
            <span>Edit Profile</span>
        </a>
        <a href="session.php">
            <i class="fas fa-clock"></i>
            <span>Your Session</span>
        </a>
        <a href="reservation.php">
            <i class="fas fa-calendar-alt"></i>
            <span>Reservation</span>
        </a>
        <a href="index.php">
            <i class="fas fa-sign-out-alt"></i>
            <span>Log Out</span>
        </a>
    </div>
    <div class="frame">
        <div class="edit-content">
            <h1>EDIT PROFILE</h1>
            <form id="profileForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="name-group">
                    <div class="input-group">
                        <label>First Name</label>
                        <input type="text" name="fname" value="<?php echo $userData['fname']; ?>" readonly>
                    </div>
                    <div class="input-group">
                        <label>Middle Name</label>
                        <input type="text" name="mname" value="<?php echo $userData['mname']; ?>" readonly>
                    </div>
                </div>
                <div class="name-group">
                    <div class="input-group">
                        <label>Last Name</label>
                        <input type="text" name="lname" value="<?php echo $userData['lname']; ?>" readonly>
                    </div>
                    <div class="input-group">
                        <label>Age</label>
                        <input type="text" name="age" value="<?php echo $userData['age']; ?>" readonly>
                    </div>
                </div>
                <div class="name-group">
                    <div class="input-group">
                        <label>Gender</label>
                        <input type="text" name="gender" value="<?php echo $_SESSION['gender']; ?>" readonly>
                    </div>
                    <div class="input-group">
                        <label>Number</label>
                        <input type="text" name="number" value="<?php echo $userData['number']; ?>" readonly>
                    </div>
                </div>
                <div class="name-group">
                    <div class="input-group">
                        <label>Address</label>
                        <input type="text" name="address" value="<?php echo $userData['address']; ?>" readonly>
                    </div>
                    <div class="input-group">
                        <label>Username</label>
                        <input type="text" name="uname" value="<?php echo $_SESSION['uname']; ?>" readonly>
                    </div>
                </div>
                <div class="button-group">
                    <button type="button" id="editButton">Edit</button>
                    <button type="submit" id="updateButton" style="display: none;">Update</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editButton = document.getElementById('editButton');
            var updateButton = document.getElementById('updateButton');
            var formInputs = document.querySelectorAll('#profileForm input');

            editButton.addEventListener('click', function() {
                // Make all input fields editable
                formInputs.forEach(function(input) {
                    input.removeAttribute('readonly');
                });
                // Change the button text to "Update"
                editButton.style.display = 'none';
                updateButton.style.display = 'inline-block';
            });

            updateButton.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent form submission
                // Submit the form programmatically
                document.getElementById('profileForm').submit();
            });
        });
    </script>
</body>
</html>
