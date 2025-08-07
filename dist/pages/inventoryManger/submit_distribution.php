<?php
session_start();
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['distribution']) && is_array($_POST['distribution'])) {
    $errors = [];
    $success = [];

    // Optionally start transaction
    mysqli_begin_transaction($conn);

    foreach ($_POST['distribution'] as $distIndex => $distribution) {
        // Validate unit_id
        if (empty($distribution['unit_id'])) {
            $errors[] = "Unit is missing for distribution group #$distIndex.";
            continue;
        }
        $unit_id = intval($distribution['unit_id']);

        if (empty($distribution['items']) || !is_array($distribution['items'])) {
            $errors[] = "No items found for distribution group #$distIndex.";
            continue;
        }

        foreach ($distribution['items'] as $item_id_str => $itemData) {
            $item_id = intval($item_id_str);

            if (isset($itemData['selected']) && $itemData['selected'] == '1') {
                $qty = isset($itemData['qty']) ? intval($itemData['qty']) : 0;
                $remarks = isset($itemData['remarks']) ? trim($itemData['remarks']) : '';

                if ($qty <= 0) {
                    $errors[] = "Quantity must be greater than zero for Item ID $item_id.";
                    continue;
                }

                // Check current stock
                $stmtCheck = mysqli_prepare($conn, "SELECT quantity FROM inventory_item WHERE item_id = ?");
                mysqli_stmt_bind_param($stmtCheck, "i", $item_id);
                mysqli_stmt_execute($stmtCheck);
                mysqli_stmt_bind_result($stmtCheck, $current_quantity);
                mysqli_stmt_fetch($stmtCheck);
                mysqli_stmt_close($stmtCheck);

                if ($current_quantity === null) {
                    $errors[] = "Item ID $item_id not found in inventory.";
                    continue;
                }

                if ($qty > $current_quantity) {
                    $errors[] = "Insufficient stock for Item ID $item_id. Available: $current_quantity.";
                    continue;
                }

                // Insert distribution
                $stmtInsert = mysqli_prepare($conn, "INSERT INTO item_distributions (unit_id, item_id, distributed_quantity, remarks) VALUES (?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmtInsert, "iiis", $unit_id, $item_id, $qty, $remarks);
                if (!mysqli_stmt_execute($stmtInsert)) {
                    $errors[] = "Failed to insert distribution for Item ID $item_id: " . mysqli_stmt_error($stmtInsert);
                    mysqli_stmt_close($stmtInsert);
                    continue;
                }
                mysqli_stmt_close($stmtInsert);

                // Update stock quantity
                $stmtUpdate = mysqli_prepare($conn, "UPDATE inventory_item SET quantity = quantity - ? WHERE item_id = ?");
                mysqli_stmt_bind_param($stmtUpdate, "ii", $qty, $item_id);
                if (!mysqli_stmt_execute($stmtUpdate)) {
                    $errors[] = "Failed to update stock for Item ID $item_id: " . mysqli_stmt_error($stmtUpdate);
                } else {
                    $success[] = "Distributed $qty units of Item ID $item_id to Unit ID $unit_id.";
                }
                mysqli_stmt_close($stmtUpdate);
            }
        }
    }

    if (empty($errors)) {
        mysqli_commit($conn);
    } else {
        mysqli_rollback($conn);
    }

    // Show results (you can improve UI)
 echo "<!DOCTYPE html><html><head><link href='https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css' rel='stylesheet'></head><body class='p-4'>";
echo "<h4>Distribution Result</h4>";

if (!empty($success)) {
    echo "<div class='alert alert-success'><ul>";
    echo"Success Add";
    echo "</ul></div>";
}

if (!empty($errors)) {
    echo "<div class='alert alert-danger'><ul>";
  
    echo "</ul></div>";
}

echo "<a href='distribute_item_form.php' class='btn btn-primary'>Back to Form</a>";
echo "</body></html>";

} else {
    echo "<script>alert('Invalid form submission'); window.location.href='your_form_file.php';</script>";
}

?>
