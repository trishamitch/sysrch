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
    <h1>Welcome, <?php echo ucfirst($_SESSION['fname']); ?></h1>

</body>
</body>
</html>

<?php
} else {
    header("Location: index.php");
    exit();
}
?>
