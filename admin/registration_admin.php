<?php
    include "db_conn.php";

    $error = ""; // Initialize error message variable

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        
        $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
        $mname = isset($_POST['mname']) ? $_POST['mname'] : '';
        $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
        $type = isset($_POST['type']) ? $_POST['type'] : '';
        $uname = isset($_POST['uname']) ? $_POST['uname'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $cpassword = isset($_POST['cpassword']) ? $_POST['cpassword'] : '';
    
        // Check if any of the fields are empty
        if (empty($fname) || empty($lname) || empty($type) || empty($uname) || empty($password) || empty($cpassword)) {
            $error = "All fields are required";
        } elseif ($password !== $cpassword) {
            $error = "Password does not match";
        } else {
            // Prepare and bind the statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO admin (fname, mname, lname, type, uname, password) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $fname, $mname, $lname, $type, $uname, $password);
    
            // Execute the statement
            if ($stmt->execute()) {
                header("Location: admin_login.php?success=Your account has been created successfully");
                exit();
            } else {
                // Redirect with an error message
                $error = "Registration failed";
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>REGISTER</title>
    <link rel="stylesheet" type="text/css" href="registration_style.css">
</head>
<body>
    <div class="container">
        <header>Registration</header>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="#" method="POST">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Personal Details</span>
                    <div class="fields">
                        <div class="input-field">
                            <label>First Name</label>
                            <input type="text" placeholder="Enter your first name" name="fname">
                        </div>
                        <div class="input-field">
                            <label>Middle Name</label>
                            <input type="text" placeholder="Enter Middle Name" name="mname">
                        </div>
                        <div class="input-field">
                            <label>Last Name</label>
                            <input type="text" placeholder="Enter your Last Name" name="lname">
                        </div>
                        <div class="input-field">
                            <label>Type</label>
                            <select name="type"> <!-- Add name attribute here -->
                                <option disabled selected value="">Select Type</option>
                                <option value="Staff">Staff</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="account">
                    <span class="title">Account</span>
                    <div class="fields">
                        <div class="input-field">
                            <label>Username</label>
                            <input type="text" placeholder="Enter username" name="uname">
                        </div>
                        <div class="input-field">
                            <label>Password</label>
                            <input type="password" placeholder="Enter password" name="password">
                        </div>
                        <div class="input-field">
                            <label>Confirm Password</label>
                            <input type="password" placeholder="Confirm Password" name="cpassword">
                        </div>
                    </div>
                    <div class="buttons">
                        <button type="submit">Register</button>
                        <a href="admin_login.php" class="backBtn">Cancel</a>
                    </div>  
                </div> 
            </div>
        </form>
    </div>
</body>
</html>
