<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $sql = "SELECT * FROM users WHERE username = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['username'] = $username;
                    header("Location: welcome.php");
                    exit();
                } else {
                    echo "Incorrect password.";
                }
            } else {
                echo "User not found.";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['register'])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];

        if ($password !== $confirm_password) {
            echo "Passwords do not match.";
        } else {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
                if (mysqli_stmt_execute($stmt)) {
                    echo '<div class="box">Registration successful</div>';
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login & Registration Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
        <header>Login</header>
        <form action="#" method="post">
            <input type="text" name="username" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <input type="submit" name="login" class="button" value="Login">
        </form>
        <div class="signup">
            <span class="signup">Don't have an account? <label for="check">Signup</label></span>
        </div>
    </div>
    <div class="registration form">
        <header>Signup</header>
        <form action="#" method="post">
            <input type="text" name="username" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Create a password" required>
            <input type="password" name="confirm_password" placeholder="Confirm your password" required>
            <input type="submit" name="register" class="button" value="Signup">
        </form>
        <div class="signup">
            <span class="signup">Already have an account? <label for="check">Login</label></span>
        </div>
    </div>
</div>
</body>
</html>
