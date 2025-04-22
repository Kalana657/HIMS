<?php
session_start(); // Enable session
include('db_connect.php');

// Collect and sanitize input
$username = mysqli_real_escape_string($conn, $_POST['username']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
$role_id = mysqli_real_escape_string($conn, $_POST['role']); // Optional if role is saved elsewhere

// Set current time (optional, if Update_time is required)
$update_time = date("Y-m-d H:i:s");

// Validate if email already exists
$email_check_query = "SELECT * FROM user WHERE Email = '$email' LIMIT 1";
$email_check_result = mysqli_query($conn, $email_check_query);
$email_check_row = mysqli_fetch_assoc($email_check_result);

if ($email_check_row) {
    // Email already exists
    $_SESSION['status'] = "error";
    $_SESSION['message'] = "This email is already in use. Please use a different email address.";
    mysqli_close($conn);
    header("Location: Addnewuser.php");
    exit;
}

// Insert new user if email does not exist
$sql = "INSERT INTO user (User_name, Email, Password, Role_id,Update_time)
        VALUES ('$username', '$email', '$password','$role_id','$update_time')";

if (mysqli_query($conn, $sql)) {
    $_SESSION['status'] = "success";
    $_SESSION['message'] = "User added successfully!";
} else {
    $_SESSION['status'] = "error";
    $_SESSION['message'] = "Failed to add user: " . mysqli_error($conn);
}

mysqli_close($conn);

// Redirect back to the form
header("Location: Addnewuser.php");
exit;
?>
