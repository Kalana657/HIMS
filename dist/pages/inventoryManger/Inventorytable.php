<?php
session_start();
include('db_connect.php'); // Your database connection file
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>HIMS ADMIN | Inventory Add Requests Table</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery (Required for Bootstrap JS) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Bootstrap 4 JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Optional: AdminLTE or other CSS/JS can be included here -->
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3 class="mb-4">Inventory Add Requests Table</h3>

    <?php
    // SweetAlert2 message for session feedback
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
    ?>

    <?php
    // Fetch data for filters
    $categories = mysqli_query($conn, "SELECT * FROM inventory_category");
    $types = mysqli_query($conn, "SELECT * FROM inventory_type");
    $subtypes = mysqli_query($conn, "SELECT * FROM inventory_subtype");

    // Query main items
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
    ?>

    <!-- Filters -->
    <div class="row mb-3">
        <div class="col-md-3">
            <select id="filterCategory" class="form-control">
                <option value="">All Categories</option>
                <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                    <option value="<?= htmlspecialchars($cat['category_name']) ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-3">
            <select id="filterType" class="form-control">
                <option value="">All Types</option>
                <?php while ($type = mysqli_fetch_assoc($types)): ?>
                    <option value="<?= htmlspecialchars($type['type_name']) ?>"><?= htmlspecialchars($type['type_name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-3">
            <select id="filterSubtype" class="form-control">
                <option value="">All Subtypes</option>
                <?php while ($sub = mysqli_fetch_assoc($subtypes)): ?>
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
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
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

            <!-- Modal -->
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
                                    <div class="form-group">
                                        <label for="quantity<?= $row['item_id'] ?>"><strong>Admin Approved Quantity</strong></label>
                                        <input type="number" name="quantity" id="quantity<?= $row['item_id'] ?>" value="<?= $requestedQty ?>" max="<?= $approvedQty ?>" class="form-control" required oninput="validateQty<?= $row['item_id'] ?>()">
                                        <small id="errorMsg<?= $row['item_id'] ?>" class="text-danger" style="display:none;">Requested quantity cannot exceed approved quantity!</small>
                                    </div>
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
                                <div class="col-md-6 mb-3">
                                    <label for="comment<?= $row['item_id'] ?>"><strong>Comment</strong></label>
                                    <textarea class="form-control" id="comment<?= $row['item_id'] ?>" rows="4"><?= htmlspecialchars($row['comment']) ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- Approve button submits via AJAX -->
                            <button type="button" class="btn btn-success" id="approveBtn<?= $row['item_id'] ?>" onclick="submitApproval(<?= $row['item_id'] ?>)">Approve</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>

                        <script>
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

                                // AJAX POST to update approval (you need to create update_approval.php)
                                $.post('update_approval.php', {
                                    item_id: itemId,
                                    approved_quantity: qtyInput.value,
                                    comment: commentInput.value
                                }, function(response) {
                                    // Response should be JSON with status and message
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
        <?php endwhile; ?>
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

                var categoryMatch = category === "" || rowCategory === category;
                var typeMatch = type === "" || rowType === type;
                var subtypeMatch = subtype === "" || rowSubtype === subtype;
                var searchMatch = name.includes(search) || desc.includes(search) || serial.includes(search);

                if (categoryMatch && typeMatch && subtypeMatch && searchMatch) {
                    row.show();
                } else {
                    row.hide();
                }
            });
        }

        $('#filterCategory, #filterType, #filterSubtype, #searchInput').on('input change', filterTable);
    });
</script>

</body>
</html>
