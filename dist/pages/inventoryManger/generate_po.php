<?php
session_start();
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = $_POST['item_id'];
    $vendor_id = $_POST['vendor_id'];
    $suggested_qty = $_POST['suggested_qty'];

    // Fetch vendor price per unit
    $vendor_query = $conn->prepare("SELECT item_price FROM vendors WHERE vendor_id = ?");
    $vendor_query->bind_param("i", $vendor_id);
    $vendor_query->execute();
    $vendor_query->bind_result($price_per_unit);
    $vendor_query->fetch();
    $vendor_query->close();

    $total_cost = $price_per_unit * $suggested_qty;

    $insert_po = $conn->prepare("INSERT INTO purchase_orders (item_id, vendor_id, quantity, price_per_unit, total_cost, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $insert_po->bind_param("iiidd", $item_id, $vendor_id, $suggested_qty, $price_per_unit, $total_cost);

    if ($insert_po->execute()) {
        $_SESSION['status'] = "success";
        $_SESSION['message'] = "Purchase Order generated successfully!";
    } else {
        $_SESSION['status'] = "error";
        $_SESSION['message'] = "Failed to generate PO.";
    }

    $insert_po->close();
    header("Location: procurmenttable.php");
    exit();
}
?>
