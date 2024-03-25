    <?php
    // Include your database connection file here
    include "db_conn.php";

    if(isset($_POST["query"])) {
        $search = $_POST["query"];
        // Assuming idno, firstname, middlename, and lastname are the fields you want to search for
        $sql = "SELECT idno, fname, mname, lname FROM users WHERE idno = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $search);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='user'>";
                echo "<label>User ID:</label><input type='text' value='" . $row["idno"] . "' readonly><br>";
                echo "<label>First Name:</label><input type='text' value='" . $row["fname"] . "' readonly><br>";
                echo "<label>Middle Name:</label><input type='text' value='" . $row["mname"] . "' readonly><br>";
                echo "<label>Last Name:</label><input type='text' value='" . $row["lname"] . "' readonly><br>";
                // Fetch remaining sessions for the user
                $user_id = $row["idno"];
                $sql_sessions = "SELECT COUNT(*) AS total_sessions FROM reservations WHERE user_id = ?";
                $stmt_sessions = $conn->prepare($sql_sessions);
                $stmt_sessions->bind_param("i", $user_id);
                $stmt_sessions->execute();
                $result_sessions = $stmt_sessions->get_result();
                $total_sessions = 0;

                if ($result_sessions->num_rows > 0) {
                    $row_sessions = $result_sessions->fetch_assoc();
                    $total_sessions = $row_sessions["total_sessions"];
                }

                $sessions_remaining = 30 - $total_sessions; // Calculate remaining sessions

                // Display reservation form
                echo "<div id='reservationForm'>";
                echo "<form id='reservationFormInner' action='reserve_sitin.php' method='post'>"; // Modified action attribute
                echo "<input type='hidden' id='userId' name='userId' value='" . $row["idno"] . "'>";
                echo "<label for='purpose'>Purpose:</label>";
                echo "<select id='purpose' name='purpose'>";
                echo "<option value='' disabled selected hidden>Select Purpose</option>"; // Placeholder added
                echo "<option value='Java'>Java</option>";
                echo "<option value='C++'>C++</option>";
                echo "<option value='C'>C</option>";
                echo "<option value='C#'>C#</option>";
                echo "<option value='Python'>Python</option>";
                echo "<option value='Php'>Php</option>";
                echo "<option value='Kotlin'>Kotlin</option>";
                echo "<option value='JavaScript'>JavaScript</option>";
                echo "<option value='HTML/CSS'>HTML/CSS</option>";
                echo "<option value='Database'>Database</option>";
                echo "<option value='Research'>Research</option>";
                echo "</select>";
                
                echo "<select id='labRoom' name='labRoom'>";
                echo "<option value='' disabled selected hidden>Select Lab Room</option>"; // Placeholder added
                echo "<option value='Lab 524'>Lab 524</option>";
                echo "<option value='Lab 526'>Lab 526</option>";
                echo "<option value='Lab 528'>Lab 528</option>";
                echo "<option value='Lab 529'>Lab 529</option>";
                echo "<option value='Lab 542'>Lab 542</option>";
                echo "<option value='Lab 544'>Lab 544</option>";
                echo "</select>";
                // Display the remaining sessions inside the form
                echo "<label for='sessions'>Sessions Remaining: </label>";
                echo "<input type='text' id='sessions' name='sessions' value='" . $sessions_remaining . "' readonly><br>";
                echo "<button type='submit'>Reserve Sit-In</button>"; // Changed to submit button
                echo "</form>";
                echo "</div>"; // End of reservation form
                echo "</div><br>";
            }
        } else {
            echo "No results found";
        }
    }
    ?>
