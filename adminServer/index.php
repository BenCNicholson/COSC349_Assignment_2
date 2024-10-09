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
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Prepare and execute your SQL query to check credentials
            $sqli = "SELECT * FROM Admin_ WHERE email = ? AND _password = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $username, $password); // Use appropriate types
            $stmt->execute();
            $result = $stmt->get_result();
            echo "here";
            if ($result->num_rows > 0) {
                // Successful login
                echo "<p>Login successful!</p>";
                // Redirect to another page or perform other actions here

            } else {
                // Failed login
                echo "<p style='color:red;'>Invalid username or password.</p>";
            }

            $stmt->close();
            $conn->close();
        }
        ?>
    </div>
</body>
</html>