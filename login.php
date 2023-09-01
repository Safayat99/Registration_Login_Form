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
    <title>login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="form-container">
        <h2 class="form-title">Login</h2>
        <?php
        if (isset($_POST["login"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
            require_once "connection.php";
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($db, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                if (password_verify($password, $user["password"])) {
                    session_start();
                    $_SESSION["user"] = "yes";
                    header("Location: index.php");
                    die();
                } else {
                    echo "<div class='alert alert-danger'>Password does not match</div>";
                }
            } else {
                echo '<div class="alert alert-danger">Email does not match</div>';
            }
        }
        ?>
        <form action="login.php" method="post">
            <input type="email" name="email" class="form-input" placeholder="Email" required>
            <input type="password" name="password" class="form-input" placeholder="Password" required>
            <button type="submit" name="login" class="form-button">Login</button>
        </form>
        <p class="form-link">Not registered yet? <a href="registration.php">Register Here</a></p>
    </div>

</body>

</html>