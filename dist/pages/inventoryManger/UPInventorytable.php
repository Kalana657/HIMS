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
        WHERE inventory_item.category_id =2 &&  inventory_item.status = 1
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
                 
                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#updateModal<?= $row['item_id'] ?>" title="Update Item">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                </td>
            </tr>

            <!-- Details Modal -->
          
            <!-- Update Modal -->
            <div class="modal fade" id="updateModal<?= $row['item_id'] ?>" tabindex="-1" aria-labelledby="updateModalLabel<?= $row['item_id'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form id="updateForm<?= $row['item_id'] ?>" onsubmit="return submitUpdate(<?= $row['item_id'] ?>)">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-dark">
                                <h5 class="modal-title" id="updateModalLabel<?= $row['item_id'] ?>">
                                    <i class="bi bi-pencil-square"></i> Update Item - <?= htmlspecialchars($row['item_name']) ?>
                                </h5>
                                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Editable fields -->
                                <div class="form-group">
                                    <label for="itemName<?= $row['item_id'] ?>">Item Name</label>
                                    <input type="text" class="form-control" id="itemName<?= $row['item_id'] ?>" name="item_name" value="<?= htmlspecialchars($row['item_name']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="description<?= $row['item_id'] ?>">Description</label>
                                    <textarea class="form-control" id="description<?= $row['item_id'] ?>" name="description" rows="3"><?= htmlspecialchars($row['description']) ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="serialNumber<?= $row['item_id'] ?>">Serial Number</label>
                                    <input type="text" class="form-control" id="serialNumber<?= $row['item_id'] ?>" name="serial_number" value="<?= htmlspecialchars($row['serial_number']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="quantityUpdate<?= $row['item_id'] ?>">You can Updated Quantity</label>
                                    <input type="number" class="form-control" id="quantityUpdate<?= $row['approved_quantity'] ?>" name="quantity" value="<?= htmlspecialchars($row['quantity']) ?>" min="1" required>
                                </div>
                                <div class="form-group">
                                    <label for="quantityUpdate<?= $row['item_id'] ?>">Quantity</label>
                                    <input type="number" class="form-control" id="quantityUpdate<?= $row['item_id'] ?>" name="quantity" value="<?= htmlspecialchars($row['quantity']) ?>" min="1" required>
                                </div>
                                <div class="form-group">
                                    <label for="categoryUpdate<?= $row['item_id'] ?>">Category</label>
                                    <select class="form-control" id="categoryUpdate<?= $row['item_id'] ?>" name="category_id" required>
                                        <?php
                                        // Fetch all categories again for this form
                                        $catResult = mysqli_query($conn, "SELECT * FROM inventory_category");
                                        while ($catOpt = mysqli_fetch_assoc($catResult)) {
                                            $selected = ($catOpt['category_id'] == $row['category_id']) ? "selected" : "";
                                            echo '<option value="' . $catOpt['category_id'] . '" ' . $selected . '>' . htmlspecialchars($catOpt['category_name']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="typeUpdate<?= $row['item_id'] ?>">Type</label>
                                    <select class="form-control" id="typeUpdate<?= $row['item_id'] ?>" name="type_id" required>
                                        <?php
                                        $typeResult = mysqli_query($conn, "SELECT * FROM inventory_type");
                                        while ($typeOpt = mysqli_fetch_assoc($typeResult)) {
                                            $selected = ($typeOpt['type_id'] == $row['type_id']) ? "selected" : "";
                                            echo '<option value="' . $typeOpt['type_id'] . '" ' . $selected . '>' . htmlspecialchars($typeOpt['type_name']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="subtypeUpdate<?= $row['item_id'] ?>">Subtype</label>
                                    <select class="form-control" id="subtypeUpdate<?= $row['item_id'] ?>" name="subtype_id" required>
                                        <?php
                                        $subtypeResult = mysqli_query($conn, "SELECT * FROM inventory_subtype");
                                        while ($subtypeOpt = mysqli_fetch_assoc($subtypeResult)) {
                                            $selected = ($subtypeOpt['subtype_id'] == $row['subtype_id']) ? "selected" : "";
                                            echo '<option value="' . $subtypeOpt['subtype_id'] . '" ' . $selected . '>' . htmlspecialchars($subtypeOpt['subtype_name']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="item_id" value="<?= $row['item_id'] ?>">
                                <button type="submit" class="btn btn-warning">Save Changes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
</body>
</html>