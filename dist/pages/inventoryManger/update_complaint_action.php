<?php
include('db_connect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['complaint_id']);
    $status = $_POST['status'];
    $suggestion = $_POST['pharmacist_suggestion'];
    $approved_by = $_SESSION['pharmacist_id'] ?? 'system'; // fallback

    $query = "UPDATE drug_complaints 
              SET status = ?, pharmacist_suggestion = ?, approved_by = ?, updated_at = NOW() 
              WHERE id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssi', $status, $suggestion, $approved_by, $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Complaint updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    }
}
?>
