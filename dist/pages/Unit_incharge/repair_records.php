<?php


include('db_connect.php');
echo $unitid = isset($_SESSION['unitin_id']) ? intval($_SESSION['unitin_id']) : 0;

if ($unitid === 0) {
    header("Location: login.php");
    exit();
}
$query = "SELECT 
    repair_requests.*, 
    inventory_item.*, 
    repair_stages.stage_name, 
    units.unit_name 
FROM 
repair_requests
LEFT JOIN inventory_item ON repair_requests.item_id = inventory_item.item_id
LEFT JOIN repair_stages ON repair_requests.status = repair_stages.stage_id
LEFT JOIN units ON repair_requests.unit_id = units.unit_id
WHERE 
    repair_requests.unit_id = $unitid
ORDER BY 
    repair_requests.created_at DESC";

$result = mysqli_query($conn, $query);
?>

<h4>Repair Requests History</h4>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Item Name</th>
            <th>Serial No.</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Requested At</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['item_name']) ?></td>
                <td><?= htmlspecialchars($row['serial_number']) ?></td>
                <td><?= htmlspecialchars($row['reason']) ?></td>
                <td><?= htmlspecialchars(ucfirst($row['stage_name'])) ?></td>
                <td><?= htmlspecialchars($row['created_at']) ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
