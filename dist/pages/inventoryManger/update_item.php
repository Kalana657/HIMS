<?php

include('db_connect.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $item_id = isset($_POST['item_id']) ? intval($_POST['item_id']) : 0;
    if (isset($_POST['update_quantity'], $_POST['current_level'])) {
    $update_quantity = intval($_POST['update_quantity']);
    $current_level = intval($_POST['current_level']);
    $new_quantity = $update_quantity + $current_level;
    } else {
        
        $new_quantity = -1;
    }

    

    if ($item_id > 0 && $new_quantity >= 0) {
        // Prepare and execute the update query
        $stmt = $conn->prepare("UPDATE inventory_item SET quantity = ?, updated_at = NOW() WHERE item_id = ?");
        $stmt->bind_param("ii", $new_quantity, $item_id);

        if ($stmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Quantity updated successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Database error: ' . $stmt->error
            ]);
        }
        $stmt->close();
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid item ID or quantity.'
        ]);
    }
    $conn->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
}
?>
