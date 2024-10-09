<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="login-form">
        <h1>Login</h1>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>

        <?php
        include("../dbconnect.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
           
            //Prepare and execute your SQL query to check credentials
            $prep = "SELECT * FROM Room";
            $stmt = $mysqli->prepare($prep);
            $stmt->execute();
            $resultRoom = $stmt->get_result();
            $prepBook = "SELECT * FROM Booking";
            $prepBooked = $mysqli->prepare($prepBook);
            $prepBooked->execute();
            $resBooked=$prepBooked->get_result();
            echo "jere";
            if ($resultRoom->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".htmlspecialchars($row['roomNumber'])."</td>";
                    echo "<td>".htmlspecialchars($row['roomDesc'])."</td>";
                    echo "<td>".htmlspecialchars($row['costPerNight'])."</td>";
                    echo "<td>".htmlspecialchars($row['number_rooms'])."</td>";
                    echo "</tr>";
                }
            }else{
                echo "no rooms found";
            }
            if($resBooked->num_rows>0){
                while($row = $resBooked->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".htmlspecialchars($row['roomID'])."</td>";
                    echo "<td>".htmlspecialchars($row['email'])."</td>";
                    echo "<td>".htmlspecialchars($row['cost'])."</td>";
                    echo "<td>".htmlspecialchars($row['startDate'])."</td>";
                    echo "<td>".htmlspecialchars($row['endDate'])."</td>";
                    echo "</tr>";
                }
            }else{
                echo "No bookings";
            }
            $prepBooked->close();
            $stmt->close();
        }
        ?>
    </div>
</body>
</html>