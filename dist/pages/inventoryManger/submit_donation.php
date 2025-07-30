<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = intval($_POST['item_id']);
    $donate_qty = intval($_POST['donate_qty']);
    $reason = mysqli_real_escape_string($conn, $_POST['donation_reason']);
    $donated_by = mysqli_real_escape_string($conn, $_POST['donated_by']);

    // Directly update inventory_item quantity (subtract donated quantity)
    $update_query = "UPDATE inventory_item 
                     SET quantity = quantity + $donate_qty 
                     WHERE item_id = $item_id";
    mysqli_query($conn, $update_query);

    // Insert into donation_log
    $log_query = "INSERT INTO donation_log 
                    (item_id, donated_quantity, donation_reason, donated_by, donation_date) 
                  VALUES 
                    ($item_id, $donate_qty, '$reason', '$donated_by', NOW())";
    mysqli_query($conn, $log_query);

    // Redirect to donation form with success
    header("Location: donate.php?status=success");
    exit();
} else {
    // Redirect if not POST
    header("Location: donate.php?status=invalid_method");
    exit();
}
?>
