<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input data
    $sno = $_POST['sno'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Construct and execute the SQL update statement
    $sql = "UPDATE user SET username = '$username', email = '$email' WHERE sno = $sno";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_affected_rows($conn) > 0) {
        header("Location: welcome.php?message=update_success");
        exit();
    } else {
        header("Location: welcome.php?message=no_changes");
        exit();
    }
} else {
    echo "Invalid request method.";
}
mysqli_close($conn);
?>
