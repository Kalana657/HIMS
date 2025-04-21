<?php
session_start();
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role_name = mysqli_real_escape_string($conn, $_POST['role_name']);

    // Check if role already exists
    $check = "SELECT * FROM user_role WHERE Role_name = '$role_name'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['status'] = "error";
        $_SESSION['message'] = "Role already exists!";
    } else {
        $insert = "INSERT INTO user_role (Role_name) VALUES ('$role_name')";
        if (mysqli_query($conn, $insert)) {
            $_SESSION['status'] = "success";
            $_SESSION['message'] = "Role added successfully!";
        } else {
            $_SESSION['status'] = "error";
            $_SESSION['message'] = "Error: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
    header("Location: AddUserRole.php");
    exit;
}
?>
