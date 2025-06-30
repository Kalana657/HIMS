<?php
include('db_connect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $unit_id = intval($_POST['unit_id']);
    $item_id = intval($_POST['item_id']);
    $drug_type = mysqli_real_escape_string($conn, $_POST['drug_type']);
    $batch_no = mysqli_real_escape_string($conn, $_POST['batch_no']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $query = "INSERT INTO drug_complaints (unit_id, item_id, drug_type, batch_no, description)
              VALUES ($unit_id, $item_id, '$drug_type', '$batch_no', '$description')";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Complaint submitted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
