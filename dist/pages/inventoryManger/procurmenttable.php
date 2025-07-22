<?php
session_start();
include('db_connect.php'); // your DB connection
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>HIMS | Procurment Table</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128+Text&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
     <style>
     .modal-header {
    border-bottom: none;
    }
    .modal-footer {
        border-top: none;
    }
    .btn {
        border-radius: 30px;
    }
    .table thead th {
        background-color: #212529;
        color: white;
    }
    .badge.bg-danger {
        font-size: 0.9em;
    }



     </style>   


 

</head>
<body class="bg-light">
<div class="container-fluid">
        <div class="row">
         
           <?php include('Slidebari.php'); ?>

       
            <div class="col-lg-10 col-md-9 main-content">
            
                   <?php include('Header.php'); ?>
    <h3 class="mb-4">Procurment Table</h3>

    <?php
    if (isset($_SESSION['status']) && isset($_SESSION['message'])) {
        echo "
        <script>
            Swal.fire({
                icon: '" . htmlspecialchars($_SESSION['status']) . "',
                title: '" . ucfirst(htmlspecialchars($_SESSION['status'])) . "!',
                text: '" . htmlspecialchars($_SESSION['message']) . "',
                confirmButtonText: 'OK'
            });
        </script>";
        unset($_SESSION['status']);
        unset($_SESSION['message']);
    }

    // Fetch filters data
    $categories = mysqli_query($conn, "SELECT * FROM inventory_category");
    $types = mysqli_query($conn, "SELECT * FROM inventory_type");
    $subtypes = mysqli_query($conn, "SELECT * FROM inventory_subtype");

    // Fetch items and store in array for reuse
    $query = "
        SELECT 
            inventory_item.*,
            inventory_category.category_name,
            inventory_type.type_name,
            inventory_subtype.subtype_name,
            item_distributions.*
          
        FROM inventory_item
        JOIN inventory_category ON inventory_item.category_id = inventory_category.category_id
        JOIN inventory_type ON inventory_item.type_id = inventory_type.type_id
        JOIN inventory_subtype ON inventory_item.subtype_id = inventory_subtype.subtype_id
        JOIN item_distributions ON inventory_item.item_id=item_distributions.item_id 
        LEFT JOIN item_approvals ON inventory_item.related_item_id = item_approvals.approval_id
        WHERE item_distributions.distributed_quantity *0.2 >=  inventory_item.quantity *0.20
        ORDER BY inventory_item.created_at DESC
    ";
    $result = mysqli_query($conn, $query);
    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
    ?>

 
  

    <!-- Inventory Table -->
  <!-- Procurement Table Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bi bi-cart-check-fill text-primary"></i> Procurement Dashboard</h3>
    <input type="search" class="form-control w-25" id="searchInput" placeholder="Search items...">
</div>

<!-- Inventory Table -->
<div class="table-responsive shadow rounded bg-white p-3">
    <table class="table table-hover align-middle text-center" id="inventoryTable">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Qty</th>
                <th>Category</th>
                <th>Type</th>
                <th>Subtype</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $index => $row): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($row['item_name']) ?></td>
                <td><span class="badge bg-danger"><?= $row['quantity'] ?></span></td>
                <td><?= $row['category_name'] ?></td>
                <td><?= $row['type_name'] ?></td>
                <td><?= $row['subtype_name'] ?></td>
                <td>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#requestModal<?= $row['item_id'] ?>">
                        <i class="bi bi-envelope-paper"></i> Request
                    </button>
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#poModal<?= $row['item_id'] ?>">
                        <i class="bi bi-file-earmark-plus"></i> PO
                    </button>
                </td>
            </tr>

            <!-- Request Modal -->
            <div class="modal fade" id="requestModal<?= $row['item_id'] ?>" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered">
                <form method="post" action="submit_request.php">
                  <input type="hidden" name="item_id" value="<?= $row['item_id'] ?>">
                  <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                      <h5 class="modal-title"><i class="bi bi-exclamation-circle"></i> Submit Request</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <p>Item: <strong><?= $row['item_name'] ?></strong></p>
                      <label>Requested Quantity</label>
                      <input type="number" name="requested_qty" class="form-control" required>
                      <label>Reason</label>
                      <textarea name="reason" class="form-control" required></textarea>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <!-- Purchase Order Modal -->
            <div class="modal fade" id="poModal<?= $row['item_id'] ?>" tabindex="-1">
              <div class="modal-dialog modal-lg modal-dialog-centered">
                <form method="post" action="generate_po.php">
                  <input type="hidden" name="item_id" value="<?= $row['item_id'] ?>">
                  <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                      <h5 class="modal-title"><i class="bi bi-cart-check"></i> Generate Purchase Order</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row">
                      <div class="col-md-6">
                        <label>Suggested Quantity</label>
                        <input type="number" class="form-control" name="suggested_qty" value="10" required>
                      </div>
                      <div class="col-md-6">
                        <?php
                        $vendors = mysqli_query($conn, "SELECT * FROM vendors WHERE item_id = {$row['item_id']}");
                        ?>
                        <select class="form-select" name="vendor_id" required>
                            <option value="" disabled selected>Select Vendor</option>
                            <?php while ($v = mysqli_fetch_assoc($vendors)): ?>
                                <option value="<?= $v['vendor_id'] ?>">
                                    <?= htmlspecialchars($v['vendor_name']) ?> - $<?= number_format($v['item_price'], 2) ?>/unit
                                </option>
                            <?php endwhile; ?>
                        </select>

                      </div>
                      <div class="col-md-12 mt-3">
                        <h6 class="text-muted">System Estimation:</h6>
                        <ul class="list-group">
                            <li class="list-group-item">Demand Forecast: <strong><span id="forecast<?= $row['item_id'] ?>">10 units/month</span></strong></li>
                            <li class="list-group-item">Best Vendor: <strong><span id="bestVendor<?= $row['item_id'] ?>">-</span></strong></li>
                            <li class="list-group-item">Estimated Cost: <strong>$<span id="cost<?= $row['item_id'] ?>">0.00</span></strong></li>
                        </ul>

                      </div>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-success">Generate PO</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</div>

<script>
    $(document).ready(function() {
        function filterTable() {
            var category = $('#filterCategory').val().toLowerCase();
            var type = $('#filterType').val().toLowerCase();
            var subtype = $('#filterSubtype').val().toLowerCase();
            var search = $('#searchInput').val().toLowerCase();

            $('#inventoryTable tbody tr').each(function() {
                var row = $(this);
                var rowCategory = row.find('td:nth-child(5)').text().toLowerCase();
                var rowType = row.find('td:nth-child(6)').text().toLowerCase();
                var rowSubtype = row.find('td:nth-child(7)').text().toLowerCase();
                var name = row.find('td:nth-child(1)').text().toLowerCase();
                var desc = row.find('td:nth-child(2)').text().toLowerCase();
                var serial = row.find('td:nth-child(3)').text().toLowerCase();

                var matches = true;
                if (category && category !== 'all' && rowCategory !== category) matches = false;
                if (type && type !== 'all' && rowType !== type) matches = false;
                if (subtype && subtype !== 'all' && rowSubtype !== subtype) matches = false;
                if (search && !name.includes(search) && !desc.includes(search) && !serial.includes(search)) matches = false;

                row.toggle(matches);
            });
        }

        $('#filterCategory, #filterType, #filterSubtype, #searchInput').on('input change', filterTable);
        filterTable(); // Initial filter
    });

    function submitUpdate(itemId) {
        event.preventDefault();
        var form = $('#updateForm' + itemId);
        var formData = form.serialize();

        $.post('update_item.php', formData, function(response) {
            try {
                var res = JSON.parse(response);
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: res.message
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: res.message
                    });
                }
            } catch {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Unexpected server response'
                });
            }
        }).fail(function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to update item. Please try again.'
            });
        });

        return false;
    }


 




</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>