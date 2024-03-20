<?php
session_start();
include "db_conn.php";

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_reservation'])) {
    // Validate and sanitize input data
    $user_id = $_SESSION['id'];
    $room = $_POST['room'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $purpose = $_POST['purpose'];

    // Insert reservation data into the database
    $stmt = $conn->prepare("INSERT INTO reservations (user_id, room, date, time, purpose) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $room, $date, $time, $purpose);

    if ($stmt->execute()) {
        // Reservation successful, redirect to the same page to prevent form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Reservation failed
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservation</title>
    <link rel="stylesheet" type="text/css" href="home_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
        <div class="main-content">
            <h2>Make a Reservation</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="room">Select Room:</label>
                <select name="room" id="room">
                    <option value="Room 525">Room 524</option>
                    <option value="Room 526">Room 526</option>
                    <option value="Room 528">Room 528</option>
                    <option value="Room 529">Room 529</option>
                    <option value="Room 542">Room 542</option>
                    <option value="Room 544">Room 544</option>
                </select><br>

                <label for="date">Select Date:</label>
                <input type="date" name="date" id="date" required><br>

                <label for="time">Select Time:</label>
                <input type="time" name="time" id="time" required><br>

                <label for="purpose">Purpose:</label><br>
                <textarea name="purpose" id="purpose" rows="4" cols="50" required></textarea><br>

                <button type="submit" name="submit_reservation">Submit Reservation</button>
            </form>
        </div>

    </div>
</body>
</html>
