<?php
include('db_connect.php');

// Fetch items and approvals
$query = "
    SELECT 
    inventory_item.item_id,
    inventory_item.item_name,
    inventory_item.quantity,
    item_approvals.approved_quantity
FROM inventory_item
LEFT JOIN item_approvals ON inventory_item.item_id = item_approvals.item_idat
WHERE inventory_item.status = 1 AND item_approvals.approved_quantity IS NOT NULL;

";

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $item_id = $row['item_id'];
    $item_name = $row['item_name'];
    $quantity = (int)$row['quantity'];
    $approved = (int)$row['approved_quantity'];

    // Calculate thresholds
    $low_threshold = $approved * 0.20;
    $medium_threshold = $approved * 0.40;

    $message = '';
    if ($quantity <= $low_threshold) {
        $message = "⚠️ LOW STOCK: '{$item_name}' quantity ($quantity) is below 20% of approved ($approved).";
    } elseif ($quantity <= $medium_threshold) {
        $message = "⚠️ MEDIUM STOCK: '{$item_name}' quantity ($quantity) is below 40% of approved ($approved).";
    }

    if (!empty($message)) {
        // Avoid duplicate notifications
        $check = mysqli_query($conn, "SELECT * FROM notifications WHERE item_id = $item_id AND message = '".mysqli_real_escape_string($conn, $message)."' AND status = 'unread'");
        if (mysqli_num_rows($check) == 0) {
            mysqli_query($conn, "INSERT INTO notifications (item_id, message) VALUES ($item_id, '".mysqli_real_escape_string($conn, $message)."')");
        }
    }
}
?>
