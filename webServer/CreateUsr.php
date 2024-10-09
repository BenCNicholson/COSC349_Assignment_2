<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="login-form">
        <h1>Create account</h1>
        <form method="POST" action="">
            <input type="text" name="email" placeholder="email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="first_name" placeholder="firstname" required>
            <input type="password" name="last_name" placeholder="lastname" required>
            <input type="submit" value="create">
        </form>

        <?php
include("../dbconnect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $firstname = $_POST['first_name'];
    $lastname = $_POST['last_name'];
    $password = $_POST['password'];

   
    $prep = "INSERT INTO Client (email, first_name, last_name, _password) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($prep);
    if ($stmt) {
        $stmt->bind_param("ssss", $email, $firstname, $lastname, $password);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                header("Location: index.php");
                exit(); 
            } else {
                echo "<p style='color:red;'>Account already taken. Try another email.</p>";
            }
        } else {
            echo "<p style='color:red;'>Error executing statement: " . $stmt->error . "</p>";
        }
        $stmt->close(); 
    } else {
        echo "<p style='color:red;'>Error preparing statement: " . $mysqli->error . "</p>";
    }
    $mysqli->close();
}
?>

    </div>
</body>
</html>