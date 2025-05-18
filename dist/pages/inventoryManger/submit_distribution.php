<?php
session_start();
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['distribution']) && is_array($_POST['distribution'])) {
    $errors = [];
    $success = [];

    foreach ($_POST['distribution'] as $distIndex => $distribution) {
        if (!isset($distribution['unit_id']) || empty($distribution['unit_id'])) {
            $errors[] = "Unit is missing for distribution #$distIndex.";
            continue;
        }

        $unit_id = intval($distribution['unit_id']);

        if (!isset($distribution['items']) || !is_array($distribution['items'])) {
            $errors[] = "No items for distribution #$distIndex.";
            continue;
        }

        foreach ($distribution['items'] as $item_id_str => $itemData) {
            $item_id = intval($item_id_str);

            // Check if user selected this item (checkbox checked)
            if (isset($itemData['selected']) && $itemData['selected'] == '1') {
                $qty = isset($itemData['qty']) ? intval($itemData['qty']) : 0;
                $remarks = isset($itemData['remarks']) ? trim($itemData['remarks']) : '';

                if ($qty > 0) {
                    $insert_sql = "INSERT INTO item_distributions (unit_id, item_id, distributed_quantity, remarks)
                                   VALUES (?, ?, ?, ?)";
                    $stmt = mysqli_prepare($conn, $insert_sql);
                    if (!$stmt) {
                        $errors[] = "Prepare failed: " . mysqli_error($conn);
                        continue;
                    }

                    mysqli_stmt_bind_param($stmt, "iiis", $unit_id, $item_id, $qty, $remarks);

                    if (mysqli_stmt_execute($stmt)) {
                        $success[] = "Distributed Item ID $item_id to Unit ID $unit_id.";
                    } else {
                        $errors[] = "Failed to insert distribution for Item ID $item_id: " . mysqli_stmt_error($stmt);
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    $errors[] = "Quantity must be greater than zero for Item ID $item_id.";
                }
            }
        }
    }

    // Display results
    echo "<!DOCTYPE html><html><head>";
    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">';
    echo "<title>Distribution Result</title></head><body class='p-4'>";
    echo "<h4>Distribution Summary</h4>";

    if (!empty($success)) {
        echo "<div class='alert alert-success'><ul>";
        foreach ($success as $msg) {
            echo "<li>" . htmlspecialchars($msg) . "</li>";
        }
        echo "</ul></div>";
    }

    if (!empty($errors)) {
        echo "<div class='alert alert-danger'><ul>";
        foreach ($errors as $err) {
            echo "<li>" . htmlspecialchars($err) . "</li>";
        }
        echo "</ul></div>";
    }

    echo "<a href='distribute_form.php' class='btn btn-primary'>Back to Form</a>";
    echo "</body></html>";

} else {
    echo "<script>alert('Invalid form submission.'); window.location.href='distribute_form.php';</script>";
}
?>
