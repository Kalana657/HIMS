<?php
include('db_connect.php');
session_start();

if (isset($_POST['approvals'])) {
    $approvals = json_decode($_POST['approvals'], true);
    $errors = [];
    
    // Begin transaction for atomic updates
    $conn->begin_transaction();
    
    try {
        foreach ($approvals as $approval) {
            $distribution_id = intval($approval['id']);
            $qty = intval($approval['qty']);
            
            if ($distribution_id <= 0) {
                $errors[] = "Invalid distribution ID: $distribution_id";
                continue;
            }
            
            $stmt = $conn->prepare("UPDATE item_distributions SET Approval_distributed_quantity = ? WHERE distribution_id = ?");
            $stmt->bind_param("ii", $qty, $distribution_id);
            
            if (!$stmt->execute()) {
                $errors[] = "Failed to update distribution ID $distribution_id";
            }
            
            $stmt->close();
        }
        
        if (empty($errors)) {
            $conn->commit();
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Approvals updated successfully';
            echo "success";
        } else {
            $conn->rollback();
            http_response_code(500);
            echo implode("\n", $errors);
        }
    } catch (Exception $e) {
        $conn->rollback();
        http_response_code(500);
        echo "Database error: " . $e->getMessage();
    }
} else {
    http_response_code(400);
    echo "Invalid data";
}
?>