<?php
session_start();

include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = intval($_POST['item_id']);
    $quantity = intval($_POST['quantity']);
    $comment = trim($_POST['comment']);
    $status = '';

    if (isset($_POST['approve'])) {
        $status = 'approved';
        $status_code = 1; 
    } elseif (isset($_POST['reject'])) {
        $status = 'rejected';
        $status_code = 2; 

        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Invalid action.';
        header("Location: your_table_page.php");
        exit();
    }
    $update = $conn->prepare("UPDATE inventory_item SET quantity = ?, status = ?, updated_at = NOW() WHERE item_id = ?");
    $update->bind_param("iii", $quantity, $status_code, $item_id);
    $update_success = $update->execute();

    $insert = $conn->prepare("INSERT INTO item_approvals (item_id, approved_quantity, status, comment) VALUES (?, ?, ?, ?)");
    $insert->bind_param("iiss", $item_id, $quantity, $status, $comment);
    $insert_success = $insert->execute();

    if ($update_success && $insert_success) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Item ' . $status . ' successfully and saved in approval log.';
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Failed to process approval/rejection.';
    }

    header("Location: inventory_add_requests.php");
    exit();
}
