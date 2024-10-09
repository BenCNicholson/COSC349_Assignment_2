<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>
<?php
include("../dbconnect.php");

// Prepare and execute your SQL query to check credentials
$resultRoom = $mysqli->query("SELECT * FROM Room WHERE isBooked = FALSE");


echo "<h2>Rooms Available</h2>";
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

?>
 <div class="check-bookings">
        <h1>View Bookings</h1>
        <form method="POST" action="">
            <input type="text" name="email" placeholder="email" required>
            <input type="submit" value="Show your bookings">
        </form>

<?php
    include("../dbconnect.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $prep = "SELECT * FROM Booking WHERE email = ?";
        $stmt = $mysqli->prepare($prep);
        if($stmt){
            $stmt->bind_param("s",$email);
            if($stmt->execute()){
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
            }else{
                echo "<p style='color:red;'>Error executing statement: " . $stmt->error . "</p>";
            }
            $stmt->close();
        }else{
            echo "<p style='color:red;'>Error preparing statement: " . $mysqli->error . "</p>";
        }
        $mysqli->close();
    }
  
?>

</div>



<p><a href = "CreateUsr.php">Create an account</a></p>
<p><href></href></p>
<p><href></href></p>
<p><href></href></p>
</body>
</html>
