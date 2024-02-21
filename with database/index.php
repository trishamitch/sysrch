<!DOCTYPE html>
<html>
<head>
    <title>LOGIN</title>
    <link rel="stylesheet" type="text/css" href="style.css"
</head>
<body>
     <form action="login.php" method="post">
        <h2>LOGIN</h2>
        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>
        <label>User Name</label>
        <input type="text" name="uname" placeholder="User Name"><br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password">
        <div class="center">
            <a href="forgotpass.php" style="color: #706d6d" >Forgot the Password?</a>
        </div>
        <br>
        <button type="submit">Login</button>
        <br><br><br>
        <div class="links" style="color: #888">
            Don't have account <a href="register.php" style="color:#000000">Sign Up<a>
        </div>
     </form>
</body>
</html>
