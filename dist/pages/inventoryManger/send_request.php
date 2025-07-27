<?php
include('db_connect.php');
session_start();

$item_id = $_POST['item_id'];
$requested_qty = $_POST['requested_qty'];
$notes = $_POST['notes'] ?? '';
$requested_by = $_SESSION['user_id'];  // Assuming user ID in session

if (empty($item_id) || $requested_qty < 1) {
    echo json_encode(['status' => 'error', 'icon' => 'error', 'message' => 'Invalid input']);
    exit();
}

$stmt = $conn->prepare("INSERT INTO procurement_requests (item_id, requested_qty, requested_by, notes) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiis", $item_id, $requested_qty, $requested_by, $notes);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'icon' => 'success', 'message' => 'Request sent successfully!']);
} else {
    echo json_encode(['status' => 'error', 'icon' => 'error', 'message' => 'Failed to send request']);
}
$stmt->close();