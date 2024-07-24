<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $pass = $_POST['password'];

    include "config.php";

    $errors = [];

    if (!empty($email) && !empty($pass)) {
        $query = "SELECT * FROM user WHERE email='$email'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            // Verify the password
            if (password_verify($pass, $user['password'])) {

                $_SESSION['name'] = $user['username']; 
                header("Location: welcome.php");
                exit();
            } else {
                $errors[] = "Invalid credentials";
            }
        } else {
            $errors[] = "Invalid credentials";
        }
    } else {
        $errors[] = "Email and password cannot be empty";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="signup-container">
        <h1>Login</h1>
        <form class="signup-form" action="" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <!-- Display errors -->
            <?php if (!empty($errors)): ?>
                <div class="error-messages">
                    <?php foreach ($errors as $error): ?>
                        <p style="color: red;"><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php" class="login-button">Sign up</a></p>
    </div>
</body>
</html>
