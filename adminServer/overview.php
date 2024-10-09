<?php
include("../dbconnect.php");

// Prepare and execute your SQL query to check credentials
$resultRoom = $mysqli->query("SELECT * FROM Room ");
$resBooked = $mysqli->query("SELECT * FROM Booking");

echo "<h2>Rooms</h2>";
echo "<table>";
echo "<tr><th>Room ID</th><th>Description</th><th>Cost Per Night</th><th>Number of Rooms</th></tr>";

if ($resultRoom->num_rows > 0) {
    while ($row = $resultRoom->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['roomID']) . "</td>";
        echo "<td>" . htmlspecialchars($row['roomDesc']) . "</td>";
        echo "<td>" . htmlspecialchars($row['costPerNight']) . "</td>";
        echo "<td>" . htmlspecialchars($row['number_rooms']) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No rooms found</td></tr>";
}
echo "</table>";

echo "<h2>Bookings</h2>";
echo "<table>";
echo "<tr><th>Room ID</th><th>Email</th><th>Cost</th><th>Start Date</th><th>End Date</th></tr>";

if ($resBooked->num_rows > 0) {
    while ($row = $resBooked->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['roomID']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['cost']) . "</td>";
        echo "<td>" . htmlspecialchars($row['startDate']) . "</td>";
        echo "<td>" . htmlspecialchars($row['endDate']) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No bookings</td></tr>";
}
echo "</table>";

?>

<div class="delete-room">
    <h1>Delete a Room</h1>
    <form method="POST" action="">
        <input type="text" name="RoomID" placeholder="RoomID" required> 
        <input type="submit" value="Delete">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $roomID = $_POST['RoomID'];
        $prep = "DELETE FROM Room WHERE roomID = ?"; 
        $statement = $mysqli->prepare($prep);
        
        if ($statement) {
            $statement->bind_param("s", $roomID);
            $statement->execute();
            if ($statement->affected_rows > 0) { 
                echo "Successful deletion";
            } else {
                echo "No room found with that ID.";
            }
            $statement->close(); 
        } else {
            echo "Error preparing statement: " . $mysqli->error;
        }
        header("Location: overview.php");
        exit(); // Stop further execution
    }
    ?>
</div>
<div class="add-room">
    <h1>Add a Room</h1>
    <form method="POST" action="">
        <input type="text" name="roomNumber" placeholder="Room Number" required> 
        <input type="text" name="roomDesc" placeholder="Room Description" required> 
        <input type="text" name="number_rooms" placeholder="Number of Rooms" required> 
        <input type="text" name="costPerNight" placeholder="Cost Per Night" required> 
        <input type="submit" value="Add">
    </form>

    <?php
    // Include your database connection
    include("dbconnect.php");

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Get values from the form
        $roomNumber = $_POST['roomNumber'];
        $roomDesc = $_POST['roomDesc'];
        $number_rooms = $_POST['number_rooms'];
        $costPerNight = $_POST['costPerNight'];

        //Prepare the SQL statement to insert a new room
        $prep = "INSERT INTO Room (roomNumber, roomDesc, number_rooms, costPerNight, isBooked) VALUES (?, ?, ?, ?, ?)";
        $statement = $mysqli->prepare($prep);

        if ($statement) {
            //Bind the parameters and execute
            $False =FALSE;
            $statement->bind_param("sssss", $roomNumber, $roomDesc, $number_rooms, $costPerNight,$False);
            $statement->execute();

            if ($statement->affected_rows > 0) { 
                echo "Room added successfully.";
            } else {
                echo "Error adding room.";
            }
            $statement->close(); //Close the statement
        } else {
            echo "Error preparing statement: " . $mysqli->error; 
        }
        header("Location: overview.php");
        exit(); // Stop further execution
    }
    ?>
    <p><a href="http://<?php echo WEB_SERVER_IP; ?>">Client Front</a></p>
</div>
</body>
</html>
