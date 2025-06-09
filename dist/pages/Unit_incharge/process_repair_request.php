<?php
session_start();
include('db_connect.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'Invalid request method.';
    header("Location: index.php");
    exit();
}

// Validate input
$item_id = isset($_POST['item_id']) ? intval($_POST['item_id']) : 0;
$unit_id = isset($_POST['unit_id']) ? intval($_POST['unit_id']) : 0;
$reason = isset($_POST['reason']) ? trim($_POST['reason']) : '';

if ($item_id <= 0 || $unit_id <= 0 || empty($reason)) {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'Invalid item ID, unit ID, or reason.';
    header("Location: index.php");
    exit();
}

// Handle image upload
$image_path = '';
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/repair_images/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    $image_name = time() . '_' . basename($_FILES['image']['name']);
    $image_path = $upload_dir . $image_name;
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Failed to upload image.';
        header("Location: index.php");
        exit();
    }
}

// Insert repair request into database
$stmt = $conn->prepare("INSERT INTO repair_requests (item_id, unit_id, reason, image_path, status, created_at) VALUES (?, ?, ?, ?, 'pending', NOW())");
if (!$stmt) {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'Database prepare error: ' . $conn->error;
    
    exit();
}
$stmt->bind_param("iiss", $item_id, $unit_id, $reason, $image_path);
$success = $stmt->execute();

$updateStmt = $conn->prepare("UPDATE item_distributions SET `remarks` = '1' WHERE item_id = ? AND unit_id = ?");
if (!$updateStmt) {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'Database prepare error (update): ' . $conn->error;
    
    exit();
}
$updateStmt->bind_param("ii", $item_id, $unit_id);
$updateStmt->execute();
$updateStmt->close();




if ($success && $updateStmt) {
   

    $_SESSION['status'] = 'success';
    $_SESSION['message'] = 'Repair request submitted successfully.';
} else {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'Failed to submit repair request: ' . $stmt->error;
}
$stmt->close();

header("Location: repir.php");
exit();
?>
