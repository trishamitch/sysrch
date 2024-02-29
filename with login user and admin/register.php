<!DOCTYPE html>
<html>
<head>
    <title>REGISTER</title>
    <link rel="stylesheet" type="text/css" href="registration_style.css">
</head>
<body>
    <?php
    include "db_conn.php";

    $error = ""; // Initialize error message variable

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $idno = isset($_POST['idno']) ? $_POST['idno'] : '';
        $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
        $mname = isset($_POST['mname']) ? $_POST['mname'] : '';
        $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
        $age = isset($_POST['age']) ? $_POST['age'] : '';
        $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
        $number = isset($_POST['number']) ? $_POST['number'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $uname = isset($_POST['uname']) ? $_POST['uname'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $cpassword = isset($_POST['cpassword']) ? $_POST['cpassword'] : '';
    
        // Check if any of the fields are empty
        if (empty($idno) || empty($fname) || empty($lname) || empty($age) || empty($gender) || empty($number) || empty($address) || empty($uname) || empty($password) || empty($cpassword)) {
            $error = "All fields are required";
        } elseif ($password !== $cpassword) {
            $error = "Password does not match";
        } else {
            // Hash the password before storing it in the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
            // Prepare and bind the statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO users (idno, fname, mname, lname, age, gender, number, address, uname, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssss", $idno, $fname, $mname, $lname, $age, $gender, $number, $address, $uname, $hashed_password);
    
            // Execute the statement
            if ($stmt->execute()) {
                header("Location: index.php?success=Your account has been created successfully");
                exit();
            } else {
                // Redirect with an error message
                $error = "Registration failed";
            }
        }
    }
?>

    <div class="container">
        <header>Registration</header><?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="#" method="POST">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Personal Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Student No.</label>
                            <input type="text" placeholder="Enter your Student Number" name="idno">
                        </div>
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
                            <label>Age</label>
                            <input type="text" placeholder="Enter your age" name="age">
                        </div>

                        <div class="input-field">
                            <label>Gender</label>
                            <select name="gender">
                                <option disabled selected value="">Select gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>Number</label>
                            <input type="text" placeholder="Enter your number" name="number">
                        </div>

                        <div class="input-field">
                            <label>Address</label>
                            <input type="text" placeholder="Enter your address" name="address">
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
                        <a href="index.php" class="cancelBtn">Cancel</a>
                        <button type="submit">Register</button>
                        
                    </div>
                </div> 
            </div>
        </form>
    </div>
</body>
</html>
