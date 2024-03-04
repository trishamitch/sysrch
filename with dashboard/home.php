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
     <div class="content-container">
        <h2>Approved</h2>
        <h3>You can now sit-in in Room 542</h3>
        <p class="date">03-01-24</p> 
     </div>
</body>
</html>



<?php 
}else{
     header("Location: index.php");
     exit();
}
?>