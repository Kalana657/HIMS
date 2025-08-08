<?php
include 'db_connect.php';

$po_id = intval($_GET['id']);
$po = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT po.*, i.item_name, v.vendor_name
    FROM purchase_orders po
    JOIN inventory_item i ON po.item_id = i.item_id
    JOIN vendors v ON po.vendor_id = v.vendor_id
    WHERE po.po_id = $po_id
"));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Purchase Order #<?= $po_id ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
    <script>
        function printPage() {
            window.print();
        }
    </script>
</head>
<body class="container mt-4">
    <?php if ($po): ?>
        <h4>Purchase Order #<?= $po['po_id'] ?></h4>
        <p><strong>Item:</strong> <?= htmlspecialchars($po['item_name']) ?></p>
        <p><strong>Vendor:</strong> <?= htmlspecialchars($po['vendor_name']) ?></p>
        <p><strong>Quantity:</strong> <?= $po['quantity'] ?></p>
        <p><strong>Price per Unit:</strong> Rs.<?= number_format($po['price_per_unit'], 2) ?></p>
        <p><strong>Total Cost:</strong> Rs.<?= number_format($po['total_cost'], 2) ?></p>
        <p><strong>Created:</strong> <?= $po['created_at'] ?></p>

        <button onclick="printPage()" class="btn btn-secondary ms-2 no-print">Print</button>
    <?php else: ?>
        <div class="alert alert-danger">Purchase Order not found.</div>
    <?php endif; ?>
</body>
</html>
