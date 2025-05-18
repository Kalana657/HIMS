<?php
// Include DB connection
include('db_connect.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $unit_name = mysqli_real_escape_string($conn, $_POST['unit_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    if (!empty($unit_name)) {
        $insertQuery = "INSERT INTO units (unit_name, description) VALUES ('$unit_name', '$description')";
        if (mysqli_query($conn, $insertQuery)) {
            $_SESSION['status'] = "success";
            $_SESSION['message'] = "Unit added successfully!";
        } else {
            $_SESSION['status'] = "error";
            $_SESSION['message'] = "Error: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['status'] = "warning";
        $_SESSION['message'] = "Unit name is required.";
    }

    // Redirect to the same page to trigger SweetAlert2
    header("Location: Add_unit.php");
    exit();
}
?>
