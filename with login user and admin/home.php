<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['uname'])) {

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>HOME</title>
	<link rel="stylesheet" type="text/css" href="home_style.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
     <h1>Welcome <?php echo ucfirst($_SESSION['fname']); ?></h1>
     <form action="index.php" method="POST">
        <button type="submit" name="logout"><i class="fa fa-sign-out"></i>Logout</button>
    </form>
    <div class="ag-format-container">
          <div class="ag-courses_box">
               <div class="ag-courses_item">
                    <a href="#" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                         Edit Profile
                    </div>
                    </a>
               </div>

          <div class="ag-courses_item">
               <a href="#" class="ag-courses-item_link">
               <div class="ag-courses-item_bg"></div>

               <div class="ag-courses-item_title">
                   Sit-in
               </div>
               </a>
          </div>

          <div class="ag-courses_item">
               <a href="#" class="ag-courses-item_link">
               <div class="ag-courses-item_bg"></div>

               <div class="ag-courses-item_title">
                    View Remaining Sessions
               </div>
               </a>
          </div>

          <div class="ag-courses_item">
               <a href="#" class="ag-courses-item_link">
               <div class="ag-courses-item_bg"></div>

               <div class="ag-courses-item_title">
                    Make Reservation
               </div>
               </a>
          </div>
     </div>     
</body>
</html>

<?php 
}else{
     header("Location: index.php");
     exit();
}
 ?>
