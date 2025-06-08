<?php
session_start();
include('db_connect.php'); // your DB connection
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>HIMS ADMIN | Inventory Add Requests Table</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
<div class="container mt-4">
    <h3 class="mb-4">Inventory Add Requests Table</h3>

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
            item_approvals.approval_id,
            item_approvals.approved_quantity,
            item_approvals.comment
        FROM inventory_item
        JOIN inventory_category ON inventory_item.category_id = inventory_category.category_id
        JOIN inventory_type ON inventory_item.type_id = inventory_type.type_id
        JOIN inventory_subtype ON inventory_item.subtype_id = inventory_subtype.subtype_id
        LEFT JOIN item_approvals ON inventory_item.related_item_id = item_approvals.approval_id
        WHERE inventory_item.status = 1
        ORDER BY inventory_item.created_at DESC
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
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailsModal<?= $row['item_id'] ?>" title="View More">
                        <i class="bi bi-eye-fill"></i>
                    </button>
                   
                </td>
            </tr>

            <!-- Details Modal with Barcode -->
            <div class="modal fade" id="detailsModal<?= $row['item_id'] ?>" tabindex="-1" aria-labelledby="detailsModalLabel<?= $row['item_id'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="detailsModalLabel<?= $row['item_id'] ?>">
                                <i class="bi bi-info-circle-fill"></i> Item Details - <?= htmlspecialchars($row['item_name']) ?>
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3 bg-light border rounded p-3">
                                    <strong>Description:</strong><br><?= nl2br(htmlspecialchars($row['description'])) ?><br><br>
                                    <strong>Serial Number:</strong><br><?= htmlspecialchars($row['serial_number']) ?><br><br>
                                    <svg id="barcode<?= $row['item_id'] ?>"></svg><br><br>

                                    <strong>Batch No:</strong><br><?= htmlspecialchars($row['bn_number']) ?><br><br>
                                    <?php if ($row['vendor_id'] != 0): ?>
                                        <strong>Vendor ID:</strong><br><?= htmlspecialchars($row['vendor_id']) ?><br><br>
                                        <strong>Warranty:</strong><br><?= htmlspecialchars($row['warranty_from']) ?> to <?= htmlspecialchars($row['warranty_to']) ?><br><br>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6 mb-3 bg-light border rounded p-3">
                                    <strong>Manufacture Date:</strong><br><?= htmlspecialchars($row['manufacture_date']) ?><br><br>
                                    <strong>Expiry Date:</strong><br><?= htmlspecialchars($row['expiry_date']) ?><br><br>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <?php
                                    $approvedQty = intval($row['approved_quantity']);
                                    $requestedQty = intval($row['quantity']);
                                    ?>
                                    
                                    <script>
                                        function validateQty<?= $row['item_id'] ?>() {
                                            var input = document.getElementById('quantity<?= $row['item_id'] ?>');
                                            var errorMsg = document.getElementById('errorMsg<?= $row['item_id'] ?>');
                                            var maxQty = <?= $approvedQty ?>;
                                            if (parseInt(input.value) > maxQty) {
                                                errorMsg.style.display = 'block';
                                                input.classList.add('is-invalid');
                                            } else {
                                                errorMsg.style.display = 'none';
                                                input.classList.remove('is-invalid');
                                            }
                                        }
                                    </script>
                                </div>
                             
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- Print button -->
                            <button type="button" class="btn btn-info" onclick="printBarcode(<?= $row['item_id'] ?>, '<?= htmlspecialchars($row['item_name']) ?>', '<?= htmlspecialchars($row['serial_number']) ?>')">
                                <i class="bi bi-printer"></i> Print Barcode
                            </button>
                            <!-- Approve button -->
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>

                        <script>
                            // Generate barcode on modal shown
                            $('#detailsModal<?= $row['item_id'] ?>').on('shown.bs.modal', function () {
                                JsBarcode("#barcode<?= $row['item_id'] ?>", "<?= htmlspecialchars($row['serial_number']) ?>", {
                                    format: "CODE128",
                                    lineColor: "#0aa",
                                    width: 2,
                                    height: 40,
                                    displayValue: true
                                });
                            });

                            function submitApproval(itemId) {
                                var qtyInput = document.getElementById('quantity' + itemId);
                                var commentInput = document.getElementById('comment' + itemId);
                                var approvedQty = <?= $approvedQty ?>;

                                if (parseInt(qtyInput.value) > approvedQty) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Requested quantity cannot exceed approved quantity!'
                                    });
                                    return;
                                }

                                $.post('update_approval.php', {
                                    item_id: itemId,
                                    approved_quantity: qtyInput.value,
                                    comment: commentInput.value
                                }, function(response) {
                                    try {
                                        var res = JSON.parse(response);
                                        if (res.status === 'success') {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Approved!',
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
                                        text: 'Failed to update approval. Please try again.'
                                    });
                                });
                            }
                        </script>
                    </div>
                </div>
            </div>

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
</body>
</html>