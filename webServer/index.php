<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        h1 {
            color: #333;
        }
    </style>
</head>
<body>
<div class = "login-form">
<form method="POST" action="">
    <input type="text" name="username" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" value="Login">
</form>
<?php 
include("dbconnect.php"); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $mysqli->prepare("SELECT _password, password FROM Client WHERE email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows>0){

        $stmt->bind_result($pw);
        $stmt->fetch();
        if($password ==$pw){
            setcookie("user_id", $username, time() + (86400 * 30), "/");
            header("Location: CreateUsr.php");
            exit();
        }
    }else{
        echo "No user found with that username.";
    }
}
?>

</div>


<p><a href = "CreateUsr.php">Create an account</a></p>
<p><href></href></p>
<p><href></href></p>
<p><href></href></p>
</body>
</html>
