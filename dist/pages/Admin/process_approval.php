<?php
include('db_connect.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    $comment = $_POST['comment'];

    if (isset($_POST['approve'])) {
        $status = 1;
    } elseif (isset($_POST['reject'])) {
        $status = 2;
    }

    $sql = "UPDATE inventory_item SET quantity = ?, status = ?, admin_comment = ?, updated_at = NOW() WHERE item_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisi", $quantity, $status, $comment, $item_id);

    if ($stmt->execute()) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Item request updated successfully!';
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Failed to update request.';
    }

    header("Location: your_table_page.php");
    exit();
}
