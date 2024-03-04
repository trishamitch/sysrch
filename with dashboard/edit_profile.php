<?php
session_start(); // Start the session
include "db_conn.php";

// Check if user is logged in and session variables are set
if (!isset($_SESSION['id']) || !isset($_SESSION['uname'])) {
    header("Location: index.php");
    exit();
}

// Fetch user data from the database
$userData = array(); // Initialize empty array to store user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    // Handle error if user data is not found
    echo "Error: User data not found.";
    exit();
}

// Process form submission for updating user information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data if needed

    // Extract the submitted data
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $age = $_POST['age'];
    $number = $_POST['number'];
    $address = $_POST['address'];

    // Update the user information in the database
    $stmt_update = $conn->prepare("UPDATE users SET fname = ?, mname = ?, lname = ?, age = ?, number = ?, address = ? WHERE id = ?");
    $stmt_update->bind_param("ssssssi", $fname, $mname, $lname, $age, $number, $address, $_SESSION['id']);

    if ($stmt_update->execute()) {
        // Update session variable with the new first name
        $_SESSION['fname'] = $fname;
        
        // Redirect to the profile page with success message
        header("Location: edit_profile.php?success=User information updated successfully");
        exit();
    } else {
        // Handle error if update fails
        $error = "Error updating user information";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="home_style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1 class="logo"><img src="ccs_logo.png" alt="Logo"> Welcome <?php echo ucfirst($_SESSION['fname']); ?> </h1>
            <nav>
                <ul>
                    <li><a href="home.php">Dashboard</a></li>
                    <li><a href="edit_profile.php">Edit Profile</a></li>
                    <li><a href="#">Sit-in</a></li>
                    <li><a href="session.php">Remaining Session</a></li>
                    <li><a href="reservation.php">Make Reservation</a></li>
                    <li><a href="index.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <br>
        <h1>Edit Profile</h1>
        <?php if (!empty($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <?php if (!empty($success)) { ?>
            <p class="success"><?php echo $success; ?></p>
        <?php } ?>

        <form id="profileForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
            <div class="input-group">
                <label>Number</label>
                <input type="text" name="number" value="<?php echo $userData['number']; ?>" readonly>
            </div>
            <div class="input-group">
                <label>Address</label>
                <input type="text" name="address" value="<?php echo $userData['address']; ?>" readonly>
            </div>
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="uname" value="<?php echo $_SESSION['uname']; ?>" readonly>
            </div>
            <div class="button-group">
                <button type="button" id="editButton">Edit</button>
                <button type="submit" id="updateButton" style="display: none;">Update</button>
            </div>
        </form>

    <script>
        document.getElementById('editButton').addEventListener('click', function() {
            // Enable editing of input fields
            var inputs = document.querySelectorAll('#profileForm input[readonly]');
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].removeAttribute('readonly');
            }
            // Show the update button and hide the edit button
            document.getElementById('updateButton').style.display = 'block';
            document.getElementById('editButton').style.display = 'none';
        });
    </script>
</body>
</html>

