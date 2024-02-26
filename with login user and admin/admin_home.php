<?php 
session_start();

if (isset($_SESSION['uname'])) {
    $uname = $_SESSION['uname'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome Admin</title>
    <link rel="stylesheet" type="text/css" href="adminhome_style.css">
</head>
<body>
    <h1>Welcome, <?php echo $uname; ?></h1>
    <form action="index.php" method="POST">
        <button type="submit" name="logout">Logout</button>
    </form>
</body>
</html>

<?php 
} else {
    header("Location: index.php");
    exit();
}
?>
