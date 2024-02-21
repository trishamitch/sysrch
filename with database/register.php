<!DOCTYPE html>
<html>
<head>
    <title>REGISTER</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        .title {
            text-align: center;
        }
    </style>
</head>
<body>
    <form action="registration.php" method="post" class="register-form">
        <div class="title"><h3>Registration</h3></div>
        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>
        <div class="container">
            <div class="column">
                <label>Student No.</label>
                <input type="text" name="idno" placeholder="Student Number">

                <label>Last Name</label>
                <input type="text" name="lname" placeholder="Last Name">
                
                <label>Number</label>
                <input type="text" name="number" placeholder="Number">
                
            </div>
            <div class="column">
                <label>First Name</label>
                <input type="text" name="fname" placeholder="First Name">

                <label>Age</label>
                <input type="number" name="age" placeholder="Age">

                <label>Address</label>
                <input type="text" name="address" placeholder="Address">

            </div>
            <div class="column">
                <label>Middle Name</label>
                <input type="text" name="mname" placeholder="Middle Name">

                <label>Gender</label>
                <select name="gender">
                    <option value="female">Female</option>
                    <option value="male">Male</option>
                </select>
            </div>
        </div>
        <label>User Name</label>
        <input type="text" name="uname" placeholder="User Name">
        <label>Password</label>
        <input type="password" name="password" placeholder="Password">
        <label>Confirm Password</label>
        <input type="password" name="cpassword" placeholder="Confirm Password">
        <button type="submit">Register</button>
    </form>
</body>
</html>
