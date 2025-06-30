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
    <div class="row mb-3">
        <div class="col-md-3">
            <select id="filterCategory" class="form-control">
                <option value="">All Categories</option>
                <?php 
                mysqli_data_seek($categories, 0);
                while ($cat = mysqli_fetch_assoc($categories)): ?>
                    <option value="<?= htmlspecialchars($cat['category_name']) ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-3">
            <select id="filterType" class="form-control">
                <option value="">All Types</option>
                <?php 
                mysqli_data_seek($types, 0);
                while ($type = mysqli_fetch_assoc($types)): ?>
                    <option value="<?= htmlspecialchars($type['type_name']) ?>"><?= htmlspecialchars($type['type_name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-3">
            <select id="filterSubtype" class="form-control">
                <option value="">All Subtypes</option>
                <?php 
                mysqli_data_seek($subtypes, 0);
                while ($sub = mysqli_fetch_assoc($subtypes)): ?>
                    <option value="<?= htmlspecialchars($sub['subtype_name']) ?>"><?= htmlspecialchars($sub['subtype_name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Search by Name, Description, Serial No..." />
        </div>
    </div>

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

    function printBarcode(itemId, itemName, serialNumber) {
        var printWindow = window.open('', '_blank');
        if (!printWindow) {
            Swal.fire({
                icon: 'error',
                title: 'Popup blocked',
                text: 'Please allow popups for this site to enable printing.'
            });
            return;
        }

        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Barcode Print - ${itemName}</title>
                <style>
                    body { 
                        font-family: Arial, sans-serif;
                        text-align: center;
                        padding: 20px;
                    }
                    .barcode-container {
                        margin: 50px auto;
                        max-width: 400px;
                    }
                    .item-name {
                        font-size: 18px;
                        font-weight: bold;
                        margin-bottom: 10px;
                    }
                    .serial-number {
                        font-size: 14px;
                        margin-bottom: 20px;
                    }
                    .print-date {
                        font-size: 12px;
                        margin-top: 20px;
                        color: #666;
                    }
                    @page {
                        size: auto;
                        margin: 5mm;
                    }
                </style>
                <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"><\/script>
            </head>
            <body>
                <div class="barcode-container">
                    <div class="item-name">${itemName}</div>
                    <div class="serial-number">SN: ${serialNumber}</div>
                    <svg class="barcode"></svg>
                    <div class="print-date">Printed on: ${new Date().toLocaleString()}</div>
                </div>
                <script>
                    window.onload = function() {
                        JsBarcode(".barcode", "${serialNumber}", {
                            format: "CODE128",
                            lineColor: "#000",
                            width: 2,
                            height: 60,
                            displayValue: true,
                            fontSize: 14
                        });
                        setTimeout(function() {
                            window.print();
                            window.close();
                        }, 200);
                    }
                <\/script>
            </body>
            </html>
        `);
        printWindow.document.close();
    }

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