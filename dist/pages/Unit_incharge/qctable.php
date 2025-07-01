<?php
session_start();
 $unitid = $_SESSION['unitin_id'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HIMS - Unit Incharge Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   
</head>
<body>
    <!-- Sidebar -->
   <?php include('slide_bar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
           <?php include('header.php') ?>

        <!-- Dashboard Content -->
        
        <div class="container-fluid dashboard-content">
            <div class="row">
                <!-- Left Column -->
        
               <?php
    $categories = mysqli_query($conn, "SELECT * FROM inventory_category");
    $types = mysqli_query($conn, "SELECT * FROM inventory_type");
    $subtypes = mysqli_query($conn, "SELECT * FROM inventory_subtype");

    // Fetch items and store in array for reuse
    $query = "
          SELECT 
            inventory_item.*, 
            item_distributions.*, 
            inventory_category.*, 
            inventory_subtype.*, 
            inventory_type.*
        FROM 
            item_distributions
        JOIN 
            inventory_item ON inventory_item.item_id = item_distributions.item_id
        JOIN 
            inventory_category ON inventory_item.category_id = inventory_category.category_id
        JOIN 
            inventory_type ON inventory_item.type_id = inventory_type.type_id
        JOIN 
            inventory_subtype ON inventory_item.subtype_id = inventory_subtype.subtype_id
        JOIN 
            user ON user.unitin_id = item_distributions.unit_id
        WHERE 
            item_distributions.unit_id = $unitid && inventory_item.category_id=2 ;
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
            <th>Qty</th>
            <th>Action </th>
         
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['item_name']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= htmlspecialchars($row['serial_number']) ?></td>
                <td><?= htmlspecialchars($row['distributed_quantity']) ?></td>
               
                <td>
                        <button class="btn btn-sm btn-danger" onclick="openComplainModal(
                            <?= $row['item_id'] ?>, 
                            '<?= htmlspecialchars(addslashes($row['item_name'])) ?>', 
                            '<?= htmlspecialchars(addslashes($row['serial_number'])) ?>'
                        )">
                            <i class="bi bi-exclamation-circle"></i> Complain
                        </button>
              </td>
           
            </tr>
         <?php endforeach; ?>
        </tbody>
    </table>
            </div>
        </div>
    </div>
  

 <!-- Modal here OUTSIDE the foreach loop -->
<div class="modal fade" id="complainModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="drugComplainForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Drug Quality Complaint</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="item_id" id="item_id">
          <input type="hidden" name="unit_id" value="<?= $unitid ?>">

          <div class="mb-2">
            <label>Item ID</label>
            <input type="text" id="display_item_id" class="form-control" readonly>
          </div>
          <div class="mb-2">
            <label>Drug Name</label>
            <input type="text" id="item_name" class="form-control" readonly>
          </div>
          <div class="mb-2">
            <label>Drug Type</label>
            <input type="text" name="drug_type" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Batch Number</label>
            <input type="text" name="batch_no" id="batch_no" class="form-control" Value="<?= $row['serial_number'] ?>" readonly>
          </div>
          <div class="mb-2">
            <label>Complaint Description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>




<script>

function openComplainModal(itemId, itemName, batchNo) {
    $('#item_id').val(itemId);               // hidden input (backend)
    $('#display_item_id').val(itemId);       // visible field
    $('#item_name').val(itemName);           // visible drug name
    $('#batch_no').val(batchNo);             // visible batch number
    $('#drugComplainForm')[0].reset();       // reset the form fields
    $('#complainModal').modal('show');       // show the modal
}


$('#drugComplainForm').submit(function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.post('submit_drug_complaint.php', formData, function(response) {
        try {
            var res = JSON.parse(response);
            if (res.status === 'success') {
                Swal.fire('Submitted!', res.message, 'success');
                $('#complainModal').modal('hide');
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        } catch {
            Swal.fire('Error', 'Invalid response from server.', 'error');
        }
    });
});


</script>















 </body>
</html>
   







        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>