<?php
session_start();
include('db_connect.php');
?> 




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HHIMS - Donation Table</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128+Text&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

 

    <!-- JsBarcode CDN for barcode generation -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>






<?php


$query = "SELECT 
    item_approvals.*, 
    inventory_item.*
FROM 
    item_approvals
 JOIN 
    inventory_item ON item_approvals.item_idat = inventory_item.item_id
WHERE 
    (item_approvals.approved_quantity * 0.2) < inventory_item.quantity";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Drug Donation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">


  <div class="container-fluid">
        <div class="row">
         
                    <?php include('Slidebari.php'); ?>

                
                        <div class="col-lg-10 col-md-9 main-content">
                        
                            <?php include('Header.php'); ?>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Drug Name</th>
                <th>Available Qty</th>
                <th>Max Donation Qty</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $i = 1;
        $result->data_seek(0); // reset pointer to beginning for while loop below
        while($drug = mysqli_fetch_assoc($result)): 
            $available_qty = $drug['quantity'];
            $donate_qty = $drug['approved_quantity'] - $available_qty;
            $modal_id = "donateModal_" . $drug['item_id'];
        ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($drug['item_name']) ?></td>
                <td><?= $available_qty ?></td>
                <td class="text-danger"><?= $donate_qty ?></td>
                <td>
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#<?= $modal_id ?>">
                        Donate
                    </button>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
  </div>
</div>   
    <?php

    mysqli_data_seek($result, 0); 
    while($drug = mysqli_fetch_assoc($result)):
        $available_qty = $drug['quantity'];
        $donate_qty = $drug['approved_quantity'] - $available_qty;
        $modal_id = "donateModal_" . $drug['item_id'];
    ?>
        <div class="modal fade" id="<?= $modal_id ?>" tabindex="-1" aria-labelledby="modalLabel<?= $drug['item_id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <form method="post" action="submit_donation.php" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel<?= $drug['item_id'] ?>">Donate - <?= htmlspecialchars($drug['item_name']) ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label><strong>Available Qty:</strong></label>
                            <input type="text" class="form-control" value="<?= $available_qty ?>" readonly>
                        </div>
                        <div class="mb-2">
                            <label><strong>Max Donation Qty:</strong></label>
                            <input type="text" class="form-control text-danger" value="<?= $donate_qty ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label><strong>Donation Qty:</strong></label>
                            <input type="number" name="donate_qty" class="form-control" value="<?= $donate_qty ?>" max="<?= $donate_qty ?>" min="1" required>
                        </div>
                         <div class="mb-3">
                            <label><strong>Donation By</strong></label>
                            <textarea name="donated_by" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label><strong>Donation Reason:</strong></label>
                            <textarea name="donation_reason" class="form-control" rows="2" required></textarea>
                        </div>

                        <!-- Hidden Fields -->
                        <input type="hidden" name="item_id" value="<?= $drug['item_id'] ?>">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Confirm Donation</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endwhile; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
