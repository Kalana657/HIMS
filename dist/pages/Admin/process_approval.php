<?php
session_start();
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = intval($_POST['item_id']);
    $quantity = intval($_POST['quantity']);
    $comment = trim($_POST['comment']);

    if (isset($_POST['approve'])) {
        $status = 'approved';
        $status_code = 1;
    } elseif (isset($_POST['reject'])) {
        $status = 'rejected';
        $status_code = 2;
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Invalid action.';
        header("Location: inventory_add_requests.php");
        exit();
    }

   // Check if item already exists in item_approvals table
    $check_stmt = $conn->prepare("SELECT approval_id FROM item_approvals WHERE item_idat = ?");
    $check_stmt->bind_param("i", $item_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
       
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Item already exists in approval log. Cannot approve again.';
        header("Location: inventory_add_requests.php");
        exit();
    }

    // Update inventory_item table 
    $update_inventory = $conn->prepare("UPDATE inventory_item SET quantity = ?, status = ?, updated_at = NOW() WHERE item_id = ?");
    $update_inventory->bind_param("iii", $quantity, $status_code, $item_id);
    $inventory_success = $update_inventory->execute();

    //  Insert into item_approvals table
    $insert_approval = $conn->prepare("INSERT INTO item_approvals (item_idat, approved_quantity, status_approval, comment, created_at) VALUES (?, ?, ?, ?, NOW())");
    $insert_approval->bind_param("iiss", $item_id, $quantity, $status_code, $comment);
    $approval_success = $insert_approval->execute();

  
    if ($inventory_success && $approval_success) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Item ' . $status . ' successfully and saved in approval log.';
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Failed to process approval/rejection.';
    }

    header("Location: inventory_add_requests.php");
    exit();
}
