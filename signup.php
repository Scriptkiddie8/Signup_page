<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get input values from form
    $name = trim($_POST['names']);
    $email = trim($_POST['email']);
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm-password'];

    include "config.php";

    $errors = [];

    if (empty($name) || empty($email) || empty($pass) || empty($confirm_pass)) {
        $errors[] = "All fields are required.";
    }

    if (($pass) < 4) {
        $errors[] = "Password must contain at least 4 words.";
    }

    if ($pass !== $confirm_pass) {
        $errors[] = "Password and confirm password do not match.";
    }

    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);

    $sql = "SELECT COUNT(*) AS name_count FROM user WHERE username = '$name'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row['name_count'] > 0) {
        $errors[] = "This username is already taken.";
    }

    $sql = "SELECT COUNT(*) AS email_count FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row['email_count'] > 0) {
        $errors[] = "This email is already taken <br> Please login.";
    }

    if (empty($errors)) {

        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (username, email, password) VALUES ('$name', '$email', '$hashed_password')";

        if (mysqli_query($conn, $sql)) {
            // Redirect to login page after successful signup
            $_SESSION['name'] = $name;
            header("Location: welcome.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    // Close the connection
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="signup-container">
        <h1>Sign Up</h1>
        <form class="signup-form" action="" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="names" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm-password">Confirm Password</label>
            <input type="password" id="confirm-password" name="confirm-password" required>

            <!-- Display errors -->
            <?php if (!empty($errors)): ?>
                <div class="error-messages">
                    <?php foreach ($errors as $error): ?>
                        <p style="color: red;"><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <button type="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php" class="login-button">Login</a></p>
    </div>
</body>
</html>
