<?php
include "config.php";

// Ensure $sno is obtained from a safe source and sanitize it
$sno = $_GET['id'];

// Construct and execute the SQL query
$sql = "SELECT username, email FROM user WHERE sno = $sno";
$result = mysqli_query($conn, $sql);

$username = '';
$email = '';

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $username = $row['username'];
    $email = $row['email'];
}

mysqli_close($conn); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="signup-container">
    <h1>Update</h1>
    <form class="signup-form" action="update.php" method="POST">
        <input type="hidden" name="sno" value="<?php echo $sno; ?>">

        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>

        <button type="submit">Update</button>
    </form>
</div>
</body>
</html>
