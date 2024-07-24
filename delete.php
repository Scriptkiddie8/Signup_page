<?php
include "config.php";

$sno = $_GET['id'];

    $sql = "DELETE FROM user WHERE sno = $sno";
    $result = mysqli_query($conn, $sql);

    header("Location: login.php?message=update_success");

mysqli_close($conn);
?>
