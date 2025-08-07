<?php
include 'db_connect.php';

if (!isset($_GET['table']) || !isset($_GET['id'])) {
    die("Missing parameters.");
}

$table = mysqli_real_escape_string($conn, $_GET['table']);
$id = intval($_GET['id']);

// Map allowed tables to primary keys
$primary_keys = [
    'drug_complaints' => 'complaint_id',
    'repair_requests' => 'request_id',
    'lab_results'     => 'lab_result_id',
    'reports'         => 'report_id'
];

if (!array_key_exists($table, $primary_keys)) {
    die("Unauthorized or unknown table.");
}

$primary_key = $primary_keys[$table];

// Custom JOIN queries for specific tables
switch ($table) {
    case 'drug_complaints':
        $query = "SELECT drug_complaints.*, units.*, inventory_item.* 
                  FROM drug_complaints
                  JOIN units ON drug_complaints.unit_id = units.unit_id
                  JOIN inventory_item ON drug_complaints.item_id = inventory_item.item_id
                  WHERE drug_complaints.$primary_key = $id";
        break;

    case 'repair_requests':
        $query = "SELECT repair_requests.*, units.*, inventory_item.* 
                  FROM repair_requests
                  LEFT JOIN units ON repair_requests.unit_id = units.unit_id
                  LEFT JOIN inventory_item ON repair_requests.item_id = inventory_item.item_id
                  WHERE repair_requests.$primary_key = $id";
        break;

    default:
        $query = "SELECT * FROM `$table` WHERE `$primary_key` = $id";
        break;
}



$result = mysqli_query($conn, $query);
if (!$result) {
    die("SQL Error: " . mysqli_error($conn) . "<br>Query: " . $query);
}
$data = mysqli_fetch_assoc($result);


?>
<!DOCTYPE html>
<html>
<head>
    <title>View Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h3 class="mb-3">Document Details from <?= htmlspecialchars($table) ?></h3>

    <?php if ($data): ?>
        <table class="table table-striped">
            <?php foreach ($data as $key => $value): ?>
                <tr>
                    <th><?= htmlspecialchars(ucwords(str_replace('_', ' ', $key))) ?></th>
                    <td><?= htmlspecialchars($value) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <div class="alert alert-danger">Document not found.</div>
    <?php endif; ?>

    <a href="documents.php" class="btn btn-secondary mt-3">Back to Document List</a>
</body>
</html>
