<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['uname'])) {

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>HOME</title>
	<link rel="stylesheet" type="text/css" href="home_style.css">
</head>
<body>
     <h1>Hello, <?php echo $_SESSION['fname']; ?></h1>
     <form action="index.php" method="POST">
        <button type="submit" name="logout">Logout</button>
    </form>
</body>
</html>

<?php 
}else{
     header("Location: index.php");
     exit();
}
 ?>
