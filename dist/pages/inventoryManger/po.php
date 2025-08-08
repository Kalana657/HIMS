<?php
include 'db_connect.php';

$query = "SELECT * FROM purchase_orders ORDER BY created_at DESC";
$documents = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Purchase Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h3 class="mb-4">Purchase Orders List</h3>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>PO ID</th>
                <th>Total Cost</th>
                <th>Created</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; while($doc = mysqli_fetch_assoc($documents)): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td>PO#<?= $doc['po_id'] ?></td>
                <td>Rs.<?= number_format($doc['total_cost'], 2) ?></td>
                <td><?= htmlspecialchars($doc['created_at']) ?></td>
                <td>
                    <a href="view_po.php?id=<?= $doc['po_id'] ?>" class="btn btn-sm btn-primary">View PO</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
