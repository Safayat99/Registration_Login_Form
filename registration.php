<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="form-container">
        <h2 class="form-title">Registration</h2>
        <?php

        if (isset($_POST['submit'])) {
            $fullName = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirmpassword'];
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $errors = array();

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Invalid email format");
            }

            if (strlen($password) < 8) {
                array_push($errors, "Password must be at least 8 charactes long");
            }

            if ($password !== $confirmPassword) {
                array_push($errors, "Password does not match");
            }

            require_once "connection.php";
            $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
            $result = $db->query($checkEmailQuery);

            if ($result->num_rows > 0) {
                array_push($errors, "Email already exists");
            }

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }
            } else {

                $sql = "INSERT INTO users (full_name, email, password) VALUES ('$fullName', '$email', '$passwordHash')";

                if ($db->query($sql) === TRUE) {
                    echo '<div class="alert alert-success">Registration successful</div>';
                } else {
                    echo '<div class="alert alert-danger">Something went wrong</div>';
                }
            }
        }
        ?>

        <form action="registration.php" method="POST">
            <input type="text" class="form-input" name="fullname" placeholder="Full Name" required>
            <input type="email" class="form-input" name="email" placeholder="Email" required>
            <input type="password" class="form-input" name="password" placeholder="Password" required>
            <input type="password" class="form-input" name="confirmpassword" placeholder="Confirm Password" required>
            <button type="submit" class="form-button" name="submit">Register</button>
        </form>
        <p class="form-link">Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>

</html>