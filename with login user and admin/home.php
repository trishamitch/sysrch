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
               <li><a href="#">Dashboard</a></li>
               <li><a href="#">Session</a></li>
               <li><a href="#">Notification</a></li>
               <li><a href="index.php">Logout</a></li>
          </ul>
          </nav>
     </div>
     </header>
     <div class="ag-format-container">
          <div class="ag-courses_box">
               <div class="ag-courses_item">
                    <a href="#" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>

                    <div class="ag-courses-item_title">
                         Lab Room 524
                    </div>

                    <div class="ag-courses-item_date-box">
                         Available
                         <span class="ag-courses-item_date">
                         1 hour
                         </span>
                    </div>
                    </a>
               </div>

          <div class="ag-courses_item">
               <a href="#" class="ag-courses-item_link">
               <div class="ag-courses-item_bg"></div>

               <div class="ag-courses-item_title">
                    Lab Room 526
               </div>

               <div class="ag-courses-item_date-box">
                    Available
                    <span class="ag-courses-item_date">
                    2 hours
                    </span>
               </div>
               </a>
          </div>

          <div class="ag-courses_item">
               <a href="#" class="ag-courses-item_link">
               <div class="ag-courses-item_bg"></div>

               <div class="ag-courses-item_title">
                    Lab Room 528
               </div>

               <div class="ag-courses-item_date-box">
                    Not Available
                    <span class="ag-courses-item_date">
                    .
                    </span>
               </div>
               </a>
          </div>

          <div class="ag-courses_item">
               <a href="#" class="ag-courses-item_link">
               <div class="ag-courses-item_bg"></div>

               <div class="ag-courses-item_title">
                    Lab Room 542
               </div>

               <div class="ag-courses-item_date-box">
                    Not Available
                    <span class="ag-courses-item_date">
                    .
                    </span>
               </div>
               </a>
          </div>

          <div class="ag-courses_item">
               <a href="#" class="ag-courses-item_link">
               <div class="ag-courses-item_bg"></div>

               <div class="ag-courses-item_title">
                    Lab Room 529
               </div>

               <div class="ag-courses-item_date-box">
                    Available
                    <span class="ag-courses-item_date">
                    1 hour
                    </span>
               </div>
               </a>
          </div>

          <div class="ag-courses_item">
               <a href="#" class="ag-courses-item_link">
               <div class="ag-courses-item_bg"></div>

               <div class="ag-courses-item_title">
                    Lab Room 541
               </div>

               <div class="ag-courses-item_date-box">
                    Available
                    <span class="ag-courses-item_date">
                    3 hours
                    </span>
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
