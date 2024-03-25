<!DOCTYPE html>
<html>
<head>
    <title>HOME</title>
    <link rel="stylesheet" type="text/css" href="style_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <input type="checkbox" id="check">
    <label for="check">
        <i class="fas fa-bars" id="btn"></i>
        <i class="fas fa-times" id="cancel"></i>
    </label>
    <div class="sidebar">
        <header>Menu</header>
        <a href="admin_home.php" class="active">
            <i class="fas fa-search"></i>
            <span>Search</span>
        </a>
        <a href="delete_user.php">
            <i class="fa fa-trash"></i>
            <span>Delete</span>
        </a>
        <a href="view_sitin.php">
            <i class="fa fa-users"></i> 
            <span>View Sitin Records</span>
        </a>
        <a href="#">
            <i class="fas fa-chalkboard-teacher"></i> 
            <span>Generate Reports</span>
        </a>
        <a href="index.php">
            <i class="fas fa-sign-out-alt"></i>
            <span>Log Out</span>
        </a>
    </div>
    <div class="frame">
        <h2>Search Student ID</h2>
        <div class="search">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Search">
            <i class="fas fa-times" id="clearSearch"></i>
        </div>
        <!-- Reservation Form -->

        <div class="user-container" id="userContainer">
            
        
        </div>
    </div>

    <!-- Reservation Form -->
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

            // Define reserveSitIn function outside the document ready function
            function reserveSitIn() {
                var formData = $('#reservationFormInner').serialize();
                $.ajax({
                    url: "reserve_sitin.php",
                    method: "POST",
                    data: formData,
                    success: function(response) {
                        // Handle success response
                        alert("Sit-in reserved successfully!");
                        $('#reservationForm').hide();
                        // You might want to update UI here to reflect changes
                        console.log(formData)
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error("Error occurred while reserving sit-in:", error);
                    }
                });
            }
        });
    </script>
</body>
</html>
