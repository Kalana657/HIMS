<?php
session_start();
include('db_connect.php'); // Include the database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $item_name = $_POST['item_name'];
    $description = $_POST['description'];
    $serial_number = $_POST['serial_number'];
    $quantity = $_POST['quantity'];
    $category_id = $_POST['category'];
    $type_id = $_POST['type_id'];
    $subtype_id = $_POST['subtype_id'];
    $bn_number = $_POST['bn_number'] ?? '';
    $manufacture_date = $_POST['manufacture_date'] ?? '';
    $expiry_date = $_POST['expiry_date'] ?? '';
    $warranty_from = $_POST['warranty_from'] ?? '';
    $warranty_to = $_POST['warranty_to'] ?? '';
    $vendor_id = $_POST['vendor_id'] ?? '';
    $status = 0;
   
    $related_items = $_POST['item_ids'] ?? [];

   
    $related_item_string = implode(',', $related_items);

   
    $related_item_string;

   
    $sql = "INSERT INTO inventory_item (item_name, description, serial_number, quantity, category_id, type_id, subtype_id, bn_number, manufacture_date, expiry_date, warranty_from, warranty_to, vendor_id, status,related_item_id)
            VALUES ('$item_name', '$description', '$serial_number', '$quantity', '$category_id', '$type_id', '$subtype_id', '$bn_number', '$manufacture_date', '$expiry_date', '$warranty_from', '$warranty_to', '$vendor_id', '$status','$related_item_string')";

    
    echo $sql;  
  
    if (mysqli_query($conn, $sql)) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Item added successfully!';
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Failed to add item. ' . mysqli_error($conn);  
    }

  
    header('Location: Addnewitem.php');
    exit();
}
?>
