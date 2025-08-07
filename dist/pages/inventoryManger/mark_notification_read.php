<?php
include('db_connect.php');

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Update notification status to 'read'
    $updateQuery = mysqli_query($conn, "UPDATE notifications SET status = 'read' WHERE id = $id AND status = 'unread'");

    if ($updateQuery) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>
