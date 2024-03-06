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
    <title>HOME</title>
    <link rel="stylesheet" type="text/css" href="home_style.css">
    <!-- Add a link to the FontAwesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>
     <div class="header">
        <div class="side-nav">
            <div class="user">
                <div>
                    <h1>Welcome, </h1>
                    <h3><?php echo ucfirst($_SESSION['fname']); ?></h3>
                </div>
            </div>
            <ul>
               <li <?php if(isset($_GET['dashboard'])) echo 'class="active"'; ?>><a href="?dashboard"><i class="fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
               <li <?php if(isset($_GET['edit_profile'])) echo 'class="active"'; ?>><a href="?edit_profile"><i class="fas fa-user-edit"></i><p>Edit Profile</p></a></li>
               <li <?php if(isset($_GET['sit_in'])) echo 'class="active"'; ?>><a href="?sit_in"><i class="fas fa-chair"></i><p>Sit-In</p></a></li>
               <li <?php if(isset($_GET['session'])) echo 'class="active"'; ?>><a href="?session"><i class="fas fa-clock"></i><p>Session</p></a></li>
               <li <?php if(isset($_GET['reservation'])) echo 'class="active"'; ?>><a href="?reservation"><i class="fas fa-calendar-alt"></i><p>Reservation</p></a></li>
            </ul>
            <ul>
                <li><i class="fas fa-sign-out-alt"></i><p><a href="index.php">Logout</a></p></li>
            </ul>
        </div>
    </div>

    <!-- Containers for each menu item -->
    <div id="dashboardContainer" class="container" <?php if(isset($_GET['dashboard'])) echo 'style="display:block"'; ?>>
        <!-- Content of the dashboard container goes here -->
        <!-- You can dynamically generate content using PHP -->
        <!-- For example: -->
        <h1>Dashboard</h1>
    </div>

    <div id="editProfileContainer" class="container" <?php if(isset($_GET['edit_profile']) || isset($_GET['edit_profile_success'])) echo 'style="display:block"'; ?>>
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


    <div id="sitInContainer" class="container" <?php if(isset($_GET['sit_in'])) echo 'style="display:block"'; ?>>
        <!-- Content of the sit-in container goes here -->
        <!-- You can dynamically generate content using PHP -->
        <!-- For example: -->
        <h3>Sit-In</h3>
        <p>This is the sit-in content.</p>
    </div>

    <div id="sessionContainer" class="container" <?php if(isset($_GET['session'])) echo 'style="display:block"'; ?>>
        <!-- Content of the session container goes here -->
        <!-- You can dynamically generate content using PHP -->
        <!-- For example: -->
        <h3>Session</h3>
        <p>This is the session content.</p>
    </div>

    <div id="reservationContainer" class="container" <?php if(isset($_GET['reservation'])) echo 'style="display:block"'; ?>>
        <!-- Content of the reservation container goes here -->
        <!-- You can dynamically generate content using PHP -->
        <!-- For example: -->
        <h3>Reservation</h3>
        <p>This is the reservation content.</p>
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

