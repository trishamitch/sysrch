<!DOCTYPE html>
<html>
<head>
    <title>REGISTER</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form action="registration.php" method="post">
        <h2>REGISTER</h2>
        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>
        <div class="container">
            <div class="column">
                <label>First Name</label>
                <input type="text" name="fname" placeholder="First Name"><br>

                <label>Middle Name</label>
                <input type="text" name="mname" placeholder="Middle Name"><br>

                <label>Last Name</label>
                <input type="text" name="lname" placeholder="Last Name"><br>

                <label>Age</label>
                <input type="number" name="age" placeholder="Age"><br>

                <label>Gender</label>
                <br><select name="gender">
                    <option value="female">Female</option>
                    <option value="male">Male</option>
                </select><br>
            </div>
            <div class="column">
                <label>Number</label>
                <input type="text" name="number" placeholder="Number"><br>

                <label>Address</label>
                <input type="text" name="address" placeholder="Address"><br>

                <label>User Name</label>
                <input type="text" name="uname" placeholder="User Name"><br>

                <label>Password</label>
                <input type="password" name="password" placeholder="Password"><br>

                <label>Confirm Password</label>
                <input type="password" name="cpassword" placeholder="Confirm Password"><br>
            </div>
        </div>
        <button type="submit">Register</button>
    </form>
</body>
</html>
