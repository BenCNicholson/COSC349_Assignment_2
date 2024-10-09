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
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
        $email = $_POST['email'];
        $prep = "SELECT * FROM Booking WHERE email = ?";
        $stmt = $mysqli->prepare($prep);
        if ($stmt) {
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                $resBooked = $stmt->get_result();
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
            } else {
                echo "<p style='color:red;'>Error executing statement: " . $stmt->error . "</p>";
            }
            $stmt->close();
        } else {
            echo "<p style='color:red;'>Error preparing statement: " . $mysqli->error . "</p>";
        }
    }
    ?>
</div>

<div class="check-bookings">
    <h1>Create Booking</h1>
    <form method="POST" action="">
        <input type="text" name="email" placeholder="email" required>
        <input type="text" name="roomID" placeholder="roomID" required>
        <input type="date" name="CIN" placeholder="Check In" required>
        <input type="date" name="Cout" placeholder="Check Out" required>
        <input type="submit" value="Create a Booking">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['roomID'])) {
        $email = $_POST['email'];
        $roomID = $_POST['roomID'];
        $CIN = $_POST['CIN'];
        $Cout = $_POST['Cout'];

        // Update the listing to be booked
        $prep = "UPDATE Room SET isBooked = TRUE WHERE roomID = ?";
        $stmt = $mysqli->prepare($prep);
        if ($stmt) {
            $stmt->bind_param("s", $roomID);
            if ($stmt->execute()) {   
                echo "Room Booked";       
            } else {
                echo "<p style='color:red;'>Error executing statement: " . $stmt->error . "</p>";
            }
            $stmt->close();
        } else {
            echo "<p style='color:red;'>Error preparing statement: " . $mysqli->error . "</p>";
        }

        // Get the cost per day
        $prepCost = "SELECT costPerNight FROM Room WHERE roomID = ?";
        $prepstmt = $mysqli->prepare($prepCost);
        if ($prepstmt) {
            $prepstmt->bind_param("s", $roomID);
            if ($prepstmt->execute()) { 
                $prepstmt->bind_result($costPerNight);
                $prepstmt->fetch();
                $prepstmt->close();

                // Calculate the total cost
                $checkinDate = new DateTime($CIN);
                $checkoutDate = new DateTime($Cout);
                $interval = $checkinDate->diff($checkoutDate);
                $days = $interval->days;

                if ($days > 0) {
                    $Cost = $costPerNight * $days;

                    // Create booking
                    $prepBook = "INSERT INTO Booking (email, roomID, cost, startDate, endDate) VALUES (?, ?, ?, ?, ?)";
                    $bookstmt = $mysqli->prepare($prepBook);
                    if ($bookstmt) {
                        $bookstmt->bind_param('sssss', $email, $roomID, $Cost, $CIN, $Cout);
                        if ($bookstmt->execute()) {
                           
                        } else {
                            echo "<p style='color:red;'>Error creating booking: " . $bookstmt->error . "</p>";
                        }
                        $bookstmt->close();
                    } else {
                        echo "<p style='color:red;'>Error preparing booking statement: " . $mysqli->error . "</p>";
                    }
                } else {
                    echo "<p style='color:red;'>Check-out date must be after check-in date.</p>";
                }
            } else {
                echo "<p style='color:red;'>Error executing statement: " . $prepstmt->error . "</p>";
            }
        } else {
            echo "<p style='color:red;'>Error preparing statement: " . $mysqli->error . "</p>";
        }
        header("Location: index.php");
        exit(); 
    }
    ?>
</div>
<div class ="nav"> 
<p><a href="CreateUsr.php">Create an account</a></p>
<p><a href="http://<?php echo ADMIN_SERVER_IP; ?>">Admin Login</a></p>
</div>


</body>
</html>
