<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['uname'])) {
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
        <a href="edit_profile.php">
            <i class="fas fa-user-edit"></i>
            <span>Edit Profile</span>
        </a>
        <a href="session.php">
            <i class="fas fa-clock"></i>
            <span>Your Session</span>
        </a>
        <a href="reservation.php" class="active">
            <i class="fas fa-calendar-alt"></i>
            <span>Reservation</span>
        </a>
        <a href="index.php">
            <i class="fas fa-sign-out-alt"></i>
            <span>Log Out</span>
        </a>
    </div>
    <div class="frame">
        <div class="reserve">
            <h1>Choose a Room and Time</h1>
        </div>
    </div>
</body>
</html>
<?php
} else {
     header("Location: index.php");
     exit();
}
?>