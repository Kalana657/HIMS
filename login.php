<?php
session_start();
include('db_connect.php'); 

// Collect user input
$username = $_POST['username'];
$password = $_POST['password'];
$selected_unit = $_POST['unit'];

// Basic input validation
if (empty($username) || empty($password) || empty($selected_unit)) {
    die("All fields are required.");
}

// Prepare SQL query securely
$stmt = $conn->prepare("SELECT User_id, User_name, Password, Role_id, unitin_id FROM user WHERE Email = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    //Use password_verify for encrypted passwords
    if (password_verify($password, $row['Password'])) {
        if ($row['Role_id'] == 6) {
            // Valid role, create session
            $_SESSION['user_id'] = $row['User_id'];
            $_SESSION['username'] = $row['User_name'];
            $_SESSION['unitin_id'] = $row['unitin_id'];

            // Redirect to dashboard or main system
            header("Location: dist/pages/HHIMS/Doctor/dashboard.php");
            exit();
        } else {
            echo "Access denied. Invalid role.";
        }
    } else {
        echo "Incorrect password.";
    }
} else {
    echo "User not found.";
}

$stmt->close();
$conn->close();
?>
