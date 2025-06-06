<?php
include('db_connect.php');

$category_id = $_POST['category_id'] ?? '';
$type_id = $_POST['type_id'] ?? '';
$subtype_id = $_POST['subtype_id'] ?? '';
$status = 1;

if ($category_id && $type_id && $subtype_id) {
   
    $stmt = $conn->prepare("SELECT * FROM inventory_item WHERE category_id = ? AND type_id = ? AND subtype_id = ? AND status = ?");

    if ($stmt === false) {
        echo '<p class="text-danger">Prepare failed: ' . htmlspecialchars($conn->error) . '</p>';
        exit;
    }

    $stmt->bind_param("iiii", $category_id, $type_id, $subtype_id, $status);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<div class="mb-2">
                <input type="checkbox" name="no_related_item" value="1">
                <strong>No Related Item</strong>
              </div><hr>';

        while ($row = $result->fetch_assoc()) {
            echo '<div class="mb-2">
                    <input type="checkbox" name="item_ids[]" value="' . htmlspecialchars($row['item_id']) . '">
                    <strong>' . htmlspecialchars($row['item_name']) . '</strong><br>
                    Quantity: <strong>' . htmlspecialchars($row['quantity']) . '</strong>
                  </div><hr>';
        }
    } else {
        echo '<p class="text-muted">No related items found.</p>';
    }

    $stmt->close();
} else {
    echo '<p class="text-danger">Invalid parameters.</p>';
}

$conn->close();
?>
