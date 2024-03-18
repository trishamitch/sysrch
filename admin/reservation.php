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
            <h1>Choose Room and Time</h1>
                <ul>
                <li><a href="#" class="item">Room <i class="fa fa-chevron-down"></i></a>
                    <span class="accent"></span>
                    <ul class="drop-down">
                    <li><a href="#">Room 524</a></li>
                    <li><a href="#">Room 526</a></li>
                    <li><a href="#">Room 528</a></li>
                    <li><a href="#">Room 530</a></li>
                    <li><a href="#">Room 542</a></li>
                    <li><a href="#">Room 544</a></li>
                    </ul>
                </li>
                <li><a href="#" class="item">Time <i class="fa fa-chevron-down"></i></a>
                    <span class="accent"></span>
                    <ul class="drop-down">
                    <li><a href="#">8:00-9:00 AM</a></li>
                    <li><a href="#">10:00-11:00 AM</a></li>
                    <li><a href="#">11:00-12:00 PM</a></li>
                    <li><a href="#">1:00-2:00 PM</a></li>
                    <li><a href="#">2:00-3:00 PM</a></li>
                    <li><a href="#">3:00-4:00 PM</a></li>
                    </ul>
                </li>
                <li><a href="#" class="item">Reserve</a>
                </ul>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var dropdowns = document.querySelectorAll('.drop-down');
            dropdowns.forEach(function(dropdown) {
                dropdown.parentNode.addEventListener('click', function(event) {
                    event.stopPropagation();
                    var siblingDropdowns = this.parentNode.querySelectorAll('.drop-down');
                    siblingDropdowns.forEach(function(sibling) {
                        if (sibling !== dropdown) {
                            sibling.style.display = 'none';
                        }
                    });
                    if (dropdown.style.display === 'block') {
                        dropdown.style.display = 'none';
                    } else {
                        dropdown.style.display = 'block';
                    }
                });
                document.addEventListener('click', function() {
                    dropdown.style.display = 'none';
                });
                dropdown.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            });
        });
    </script>
</body>
</html>
<?php
} else {
     header("Location: index.php");
     exit();
}
?>