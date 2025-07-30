<?php
include 'db_connect.php'; // your DB connection

// Fetch drugs where 10% of approved quantity is more than or equal to current inventory
$query = "SELECT 
    item_approvals.*,
    inventory_item.*
FROM 
    item_approvals
JOIN 
    inventory_item ON item_approvals.item_idat = inventory_item.item_id
WHERE 
    (item_approvals.approved_quantity * 10 / 100) >= inventory_item.quantity";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Drug Donation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h3>Drug Donation Form</h3>
    <form method="post" action="submit_donation.php">
        <div class="mb-3">
            <label>Donation Reason</label>
            <textarea name="donation_reason" class="form-control" required></textarea>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Drug Name</th>
                    <th>Available Qty</th>
                    <th>Donation Qty (10%)</th>
                </tr>
            </thead>
            <tbody>
                <?php while($drug = mysqli_fetch_assoc($result)): 
                    $available_qty = $drug['quantity'];
                    $donate_qty =$drug['approved_quantity']- $drug['quantity']; 
                ?>
                <tr>
                    <td><?= htmlspecialchars($drug['item_name']) ?></td>
                    <td><?= $available_qty ?></td>
                    <td>
                        <input type="number" name="donate_qty[<?= $drug['item_id'] ?>]" class="form-control" value="<?= $donate_qty ?>" min="1" max="<?= $available_qty ?>">
                        <input type="hidden" name="item_ids[]" value="<?= $drug['item_id'] ?>">
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <input type="hidden" name="donated_by" value="Inventory Manager">
        <button type="submit" class="btn btn-success">Submit Donation</button>
    </form>
</body>
</html>
