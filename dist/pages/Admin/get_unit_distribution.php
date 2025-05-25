<?php
// get_unit_distribution.php
include('db_connect.php');

if (isset($_POST['item_id'])) {
    $item_id = intval($_POST['item_id']);

    $stmt = $conn->prepare("SELECT 
        units.unit_name,
        item_distributions.*,
        SUM(item_distributions.distributed_quantity) AS distributed_quantity
    FROM 
        item_distributions
    JOIN 
        units ON item_distributions.unit_id = units.unit_id
    WHERE 
        item_distributions.item_id = ?
    GROUP BY 
        units.unit_id");

    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();

   
        
        // Inside get_unit_distribution.php
 while ($row = $result->fetch_assoc()) {
     echo '<tr data-id="'.$row['distribution_id'].'">';
    echo '<td>'.$row['unit_name'].'</td>';
    echo '<td>'.$row['distributed_quantity'].'</td>';
    echo '<td><input type="number" class="form-control approval-input" 
          value="'.$row['Approval_distributed_quantity'].'" 
          max="'.$row['distributed_quantity'].'" min="0"></td>';
    echo '</tr>';

    }

    $stmt->close();
}
?>
