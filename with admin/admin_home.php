<?php
include "db_conn.php";

if(isset($_POST["query"])) {
    $search = $_POST["query"];
    // Assuming idno, firstname, middlename, and lastname are the fields you want to search for
    $sql = "SELECT idno, firstname, middlename, lastname FROM users WHERE idno LIKE '%$search%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div>User ID: " . $row["idno"] . "<br>";
            echo "First Name: " . $row["firstname"] . "<br>";
            echo "Middle Name: " . $row["middlename"] . "<br>";
            echo "Last Name: " . $row["lastname"] . "</div><br>";
        }
    } else {
        echo "No results found";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>HOME</title>
    <link rel="stylesheet" type="text/css" href="style_admin.css">
    <!-- Add a link to the FontAwesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Add any custom styles here */
    </style>
</head>
<body>
    <input type="checkbox" id="check">
    <label for="check">
        <i class="fas fa-bars" id="btn"></i>
        <i class="fas fa-times" id="cancel"></i>
    </label>
    <div class="sidebar">
        <header>Menu</header>
        <a href="home.php" class="active">
            <i class="fas fa-qrcode"></i>
            <span>Dashboard</span>
        </a>
        <a href="edit_profile.php">
            <i class="fas fa-users"></i> <!-- Updated class name -->
            <span>Sitin Records</span>
        </a>
        <a href="session.php">
            <i class="fas fa-list"></i> <!-- Updated class name -->
            <span>Generate Report</span>
        </a>
        <a href="reservation.php">
            <i class="fas fa-redo"></i> 
            <span>Reset Session</span>
        </a>
        <a href="index.php">
            <i class="fas fa-sign-out-alt"></i>
            <span>Log Out</span>
        </a>
    </div>
    <div class="frame">
        <p>Search Student ID</p>
        <div class="search">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Search">
            <i class="fas fa-times" id="clearSearch"></i>
        </div>
        <div class="user-container" id="userContainer">
            <!-- Display search results here -->
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#searchInput').on('keyup', function(event) {
                if (event.keyCode === 13) { // Check if Enter key is pressed
                    console.log("Search triggered.");
                    searchUser();
                }
            });

            // Clear search input and hide search results when X button is clicked
            $('#clearSearch').click(function(){
                console.log("Clear search.");
                $('#searchInput').val('');
                $('#userContainer').html('');
            });

            function searchUser() {
                var query = $('#searchInput').val();
                console.log("Search query: " + query);
                if(query != ''){
                    $.ajax({
                        url:"search_users.php",
                        method:"POST",
                        data:{query:query},
                        success:function(data){
                            console.log("Search results received: " + data);
                            $('#userContainer').html(data);
                        },
                        error:function(xhr, status, error){
                            console.log("Error occurred while fetching search results.");
                            console.log(error);
                        }
                    });
                }
            }
            function deleteUser(userId) {
                // Write your code to delete the user with the given userId
                // You can use AJAX to send a request to a delete_user.php script or similar
                alert("Deleting user with ID: " + userId);
            }
        });
    </script>

</body>
</html>
