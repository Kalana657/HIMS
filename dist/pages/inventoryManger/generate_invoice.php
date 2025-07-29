<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['items'])) {
    $items = $_POST['items'];
    $total = 0;
    $po_no = 'PO-' . date('YmdHis');
    $date = date('Y-m-d');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Generated Purchase Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h3>Purchase Order - <?= $po_no ?></h3>
    <p>Date: <?= $date ?></p>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Item ID</th>
                <th>Vendor ID</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $i => $item): 
                $line_total = $item['qty'] * $item['price'];
                $total += $line_total;
            ?>
            <tr>
                <td><?= $i+1 ?></td>
                <td><?= $item['item_id'] ?></td>
                <td><?= $item['vendor_id'] ?></td>
                <td><?= $item['qty'] ?></td>
                <td><?= number_format($item['price'], 2) ?></td>
                <td><?= number_format($line_total, 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-end">Total</th>
                <th><?= number_format($total, 2) ?></th>
            </tr>
        </tfoot>
    </table>

    <button onclick="window.print()" class="btn btn-primary">Print / Save as PDF</button>
</body>
</html>
