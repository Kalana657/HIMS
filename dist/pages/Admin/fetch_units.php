<?php
include('db_connect.php');

if (isset($_POST['item_id'])) {
    $item_id = intval($_POST['item_id']);

    $stmt = $conn->prepare("
        SELECT 
            units.unit_name,
            item_distributions.distributed_quantity
        FROM 
            item_distributions
        JOIN 
            units ON item_distributions.unit_id = units.unit_id
        WHERE 
            item_distributions.item_id = ?
    ");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['unit_name']) . '</td>';
        echo '<td>' . (int)$row['distributed_quantity'] . '</td>';
        echo '</tr>';
    }

    $stmt->close();
}
?>
