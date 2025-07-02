<?php
session_start();
include('db_connect.php');
?> 




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HHIMS - Add Inventory Table</title>
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

    <style>
    @media print {
        body * {
            visibility: hidden;
        }
        .print-barcode-container, 
        .print-barcode-container * {
            visibility: visible;
        }
        .print-barcode-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 20px;
        }
        .no-print {
            display: none !important;
        }
        .barcode-print {
            margin: 20px auto;
        }
    }
    </style>
</head>
<body class="bg-light">


  <div class="container-fluid">
        <div class="row">
         
                    <?php include('Slidebari.php'); ?>

                
                        <div class="col-lg-10 col-md-9 main-content">
                        
                            <?php include('Header.php'); ?>

        
    <?php
    $categories = mysqli_query($conn, "SELECT * FROM inventory_category");
    $types = mysqli_query($conn, "SELECT * FROM inventory_type");
    $subtypes = mysqli_query($conn, "SELECT * FROM inventory_subtype");

    // Fetch items and store in array for reuse
   $query = "
    SELECT DISTINCT
        inventory_item.*, 
        inventory_category.*, 
        inventory_subtype.*, 
        inventory_type.*,
        drug_complaints.*
        FROM 
            drug_complaints
        JOIN inventory_item ON inventory_item.item_id = drug_complaints.item_id
        JOIN inventory_category ON inventory_item.category_id = inventory_category.category_id
        JOIN inventory_type ON inventory_item.type_id = inventory_type.type_id
        JOIN inventory_subtype ON inventory_item.subtype_id = inventory_subtype.subtype_id
        JOIN user ON user.unitin_id = drug_complaints.unit_id
        WHERE inventory_item.category_id = 2;
    ";

    $result = mysqli_query($conn, $query);
    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
    ?>

    <!-- Filters -->


    <!-- Inventory Table -->
    <table class="table table-bordered table-striped" id="inventoryTable">
        <thead class="thead-dark">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Batch No.</th>
            <th>Status</th>
            <th>Action </th>
         
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['item_name']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= htmlspecialchars($row['serial_number']) ?></td>
                <td>
                    <?php
                        $status = $row['status'];
                        if ($status === 'Approved') {
                            echo '<span class="badge bg-success">Approved</span>';
                        } elseif ($status === 'Rejected') {
                            echo '<span class="badge bg-danger">Rejected</span>';
                        } else {
                            echo '<span class="badge bg-secondary">Pending</span>';
                        }
                    ?>
                </td>
               
                <td>
                      <button class="btn btn-sm btn-danger" onclick="openComplainModal(
                            <?= $row['item_id'] ?>, 
                            '<?= htmlspecialchars(addslashes($row['item_name'])) ?>', 
                            '<?= htmlspecialchars(addslashes($row['serial_number'])) ?>',
                            <?= $row['id'] ?>  // complaint ID
                        )">
                            <i class="bi bi-exclamation-circle"></i> Give Action
                        </button>

              </td>
           
            </tr>
         <?php endforeach; ?>
        </tbody>
    </table>

    </div>
</div>  

  <!-- Drug Complaint Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="reviewForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Review Drug Complaint</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <input type="hidden" name="complaint_id" id="complaint_id">
          <input type="hidden" name="item_id" id="item_id">

          <div class="mb-3">
            <label>Drug Name</label>
            <input type="text" id="item_name" class="form-control" readonly>
          </div>

          <div class="mb-3">
            <label>Batch No</label>
            <input type="text" id="batch_no" name="batch_no" class="form-control" readonly>
          </div>

          <div class="mb-3">
            <label>Action</label>
            <select name="status" class="form-control" required>
              <option value="">-- Select Action --</option>
              <option value="Approved">Approved</option>
              <option value="Rejected">Rejected</option>
            </select>
          </div>

          <div class="mb-3">
            <label>Pharmacist Suggestion</label>
            <textarea name="pharmacist_suggestion" class="form-control" rows="3" required></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Submit Action</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
function openComplainModal(itemId, itemName, batchNo, complaintId) {
    $('#complaint_id').val(complaintId);
    $('#item_id').val(itemId);
    $('#item_name').val(itemName);
    $('#batch_no').val(batchNo);
    $('#reviewForm')[0].reset();
    $('#reviewModal').modal('show');
}

$('#reviewForm').submit(function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.post('update_complaint_action.php', formData, function(response) {
        try {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                Swal.fire('Updated!', res.message, 'success');
                $('#reviewModal').modal('hide');
                setTimeout(() => location.reload(), 1000);
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        } catch {
            Swal.fire('Error', 'Invalid server response.', 'error');
        }
    });
});
</script>





</body>
</html>