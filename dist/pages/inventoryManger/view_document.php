<?php
include 'db_connect.php';

if (!isset($_GET['table']) || !isset($_GET['id'])) {
    die("Missing parameters.");
}

$table = mysqli_real_escape_string($conn, $_GET['table']);
$id = intval($_GET['id']);

// Map allowed tables to primary keys
$primary_keys = [
    'drug_complaints' => 'id',  
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
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>View Document - <?= htmlspecialchars($table) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        @media print {
            #printBtn, #backBtn {
                display: none;
            }
        }
        th {
            width: 30%;
            text-align: right;
            font-weight: 600;
            vertical-align: top;
        }
    </style>
</head>
<body class="container mt-4 mb-5">
    <h3 class="mb-4">Document Details: <span class="text-primary"><?= htmlspecialchars(ucwords(str_replace('_', ' ', $table))) ?></span></h3>

    <?php if ($data): ?>
       <table class="table table-bordered table-striped">
    <tbody>
    <?php
    $exclude_fields = ['id', 'unit_id', 'item_id', 'drug_type','status', 
    'serial_number', 'Batch_No', 'approve_by','Vendor_id','Admin Comment'];
    foreach ($data as $key => $value):
        if (in_array($key, $exclude_fields)) {
            continue;
        }
    ?>
        <tr>
            <th><?= htmlspecialchars(ucwords(str_replace('_', ' ', $key))) ?></th>
            <td><?= nl2br(htmlspecialchars($value)) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

    <?php else: ?>
        <div class="alert alert-danger">Document not found.</div>
    <?php endif; ?>

    <div class="mt-4">
        <button id="printBtn" class="btn btn-success me-2" onclick="window.print()">
            <i class="bi bi-printer"></i> Print
        </button>
        <a id="backBtn" href="report_dashboard.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Document List
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.js"></script>
</body>
</html>
