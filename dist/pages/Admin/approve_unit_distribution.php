<?php
include('db_connect.php');
session_start();

if (isset($_POST['approvals'])) {
    $approvals = json_decode($_POST['approvals'], true);
    $errors = [];
    
   
    $conn->begin_transaction();
    
    try {
        foreach ($approvals as $approval) {
            $distribution_id = intval($approval['id']);
            $qty = intval($approval['qty']);
            
            if ($distribution_id <= 0 || $qty < 0) {
                $errors[] = "Invalid data for Distribution ID: $distribution_id";
                continue;
            }
            
            //  Get item_id and current inventory quantity
            $check_stmt = $conn->prepare("
                SELECT item_distributions.item_id, inventory_item.quantity AS inventory_qty
                FROM item_distributions
                JOIN inventory_item ON item_distributions.item_id = inventory_item.item_id
                WHERE item_distributions.distribution_id =?
            ");
            $check_stmt->bind_param("i", $distribution_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            
            if ($check_result->num_rows === 0) {
                $errors[] = "Distribution ID $distribution_id not found or item missing";
                $check_stmt->close();
                continue;
            }
            
            $row = $check_result->fetch_assoc();
            $item_id = $row['item_id'];
            $current_inventory_qty = $row['inventory_qty'];
            $check_stmt->close();
            
            //  Validate available quantity
            if ($current_inventory_qty < $qty) {
                $errors[] = "Insufficient stock for Item ID $item_id (Available: $current_inventory_qty, Requested: $qty)";
                continue;
            }
            
            //  Update item_distributions (approve)
            $update_dist_stmt = $conn->prepare("
                UPDATE item_distributions 
                SET Approval_distributed_quantity = ? 
                WHERE distribution_id = ?
            ");
            $update_dist_stmt->bind_param("ii", $qty, $distribution_id);
            
            if (!$update_dist_stmt->execute()) {
                $errors[] = "Failed to approve Distribution ID $distribution_id";
                $update_dist_stmt->close();
                continue;
            }
            $update_dist_stmt->close();
            
            //  Reduce inventory quantity
            $new_qty = $current_inventory_qty - $qty;
            $update_inv_stmt = $conn->prepare("
                UPDATE inventory_item 
                SET quantity = ? 
                WHERE item_id = ?
            ");
            $update_inv_stmt->bind_param("ii", $new_qty, $item_id);
            
            if (!$update_inv_stmt->execute()) {
                $errors[] = "Failed to update inventory for Item ID $item_id";
                $update_inv_stmt->close();
                continue;
            }
            $update_inv_stmt->close();
            
            // Log success
            error_log("Approved Distribution ID $distribution_id (Item ID: $item_id, Qty: $qty)");
        }
        
        // Commit or rollback
        if (empty($errors)) {
            $conn->commit();
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Approvals processed and inventory updated';
            echo json_encode(['status' => 'success']);
        } else {
            $conn->rollback();
            http_response_code(400);
            echo json_encode(['status' => 'error', 'errors' => $errors]);
        }
    } catch (Exception $e) {
        $conn->rollback();
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
}
?>