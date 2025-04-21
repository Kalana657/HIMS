<?php
include('db_connect.php');

// Collect and sanitize input
$username = mysqli_real_escape_string($conn, $_POST['username']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
$role_id = mysqli_real_escape_string($conn, $_POST['role']); // Optional if role is saved elsewhere

// Set current time (optional, if Update_time is required)
$update_time = date("Y-m-d H:i:s");

// Insert user
$sql = "INSERT INTO user (User_name, Email, Password, Update_time)
        VALUES ('$username', '$email', '$password', '$update_time')";

if (mysqli_query($conn, $sql)) {
    echo "New user created successfully.";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
