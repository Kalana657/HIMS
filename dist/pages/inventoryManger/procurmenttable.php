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
        ORDER BY inventory_item.created_at DESC
    ";
    $result = mysqli_query($conn, $query);
    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
    ?>

 
  

    <!-- Inventory Table -->
    <table class="table table-bordered table-striped" id="inventoryTable">
        <thead class="thead-dark">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Serial No.</th>
            <th>Qty</th>
            <th>Category</th>
            <th>Type</th>
            <th>Subtype</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['item_name']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= htmlspecialchars($row['serial_number']) ?></td>
                <td><?= htmlspecialchars($row['quantity']) ?></td>
                <td><?= htmlspecialchars($row['category_name']) ?></td>
                <td><?= htmlspecialchars($row['type_name']) ?></td>
                <td><?= htmlspecialchars($row['subtype_name']) ?></td>
                <td>
                 
                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#updateModal<?= $row['item_id'] ?>" title="Update Item">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                </td>
            </tr>

       
          
            <!-- Update Modal -->
        
        <?php endforeach; ?>
        </tbody>
    </table>
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