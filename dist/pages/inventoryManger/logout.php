<?php
session_start();
include('db_connect.php');

if (isset($_SESSION['user_id']) && isset($_SESSION['log_id'])) {
    $log_id = $_SESSION['log_id'];
    $logout_time = date('Y-m-d H:i:s');

    $update = "UPDATE access_logo SET logout_time = '$logout_time' WHERE id = '$log_id'";
    mysqli_query($conn, $update);
}

// Destroy session and redirect
session_unset();
session_destroy();
header("Location: ../../../index.php");
exit;
?>
