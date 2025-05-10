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

    // Handle item_ids array (checkboxes or multi-select)
    $selected_items = isset($_POST['item_ids']) ? implode(',', $_POST['item_ids']) : '';

    // Prepare SQL Query to insert the data
    $sql = "INSERT INTO inventory_item (item_name, description, serial_number, quantity, category_id, type_id, subtype_id, bn_number, manufacture_date, expiry_date, warranty_from, warranty_to, vendor_id, status)
            VALUES ('$item_name', '$description', '$serial_number', '$quantity', '$category_id', '$type_id', '$subtype_id', '$bn_number', '$manufacture_date', '$expiry_date', '$warranty_from', '$warranty_to', '$vendor_id', '$status')";

    // Debugging: Check the query being executed
    echo $sql;  // This will show the SQL query being run
    
    // Execute the query
    if (mysqli_query($conn, $sql)) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Item added successfully!';
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Failed to add item. ' . mysqli_error($conn);  // Show error message
    }

    // Redirect back to the form (after inserting the data)
    header('Location: Addnewitem.php');
    exit();
}
?>
