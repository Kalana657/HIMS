<?php
session_start();
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = intval($_POST['request_id']);
    $new_stage = intval($_POST['stage']);
    $updated_by = $_SESSION['user_id'] ?? 1;

    // Update the current request
    $updateQuery = "UPDATE repair_requests SET status = ?, updated_at = NOW() WHERE request_id = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'ii', $new_stage, $request_id);
    mysqli_stmt_execute($stmt);

    // Log stage change
    $logQuery = "INSERT INTO repair_stage_logs (request_id, stage_id, updated_by, updated_at) VALUES (?, ?, ?, NOW())";
    $logStmt = mysqli_prepare($conn, $logQuery);
    mysqli_stmt_bind_param($logStmt, 'iii', $request_id, $new_stage, $updated_by);
    mysqli_stmt_execute($logStmt);

    $_SESSION['status'] = 'success';
    $_SESSION['message'] = 'Stage updated successfully.';
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
