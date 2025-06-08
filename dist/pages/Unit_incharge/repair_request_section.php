   <?php if (isset($_SESSION['status']) && isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['status'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['status'], $_SESSION['message']); ?>
        <?php endif; ?>

        <div class="row">
            <?php
            $categories = mysqli_query($conn, "SELECT * FROM inventory_category");
            $types = mysqli_query($conn, "SELECT * FROM inventory_type");
            $subtypes = mysqli_query($conn, "SELECT * FROM inventory_subtype");

            // Fetch items
            $query = "
                SELECT 
                    inventory_item.*, 
                    item_distributions.*, 
                    inventory_category.*, 
                    inventory_type.*, 
                    inventory_subtype.*
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
                    item_distributions.unit_id = $unitid AND inventory_item.category_id != 2;
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
                            <option value="<?php echo htmlspecialchars($cat['category_name']); ?>"><?php echo htmlspecialchars($cat['category_name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="filterType" class="form-control">
                        <option value="">All Types</option>
                        <?php 
                        mysqli_data_seek($types, 0);
                        while ($type = mysqli_fetch_assoc($types)): ?>
                            <option value="<?php echo htmlspecialchars($type['type_name']); ?>"><?php echo htmlspecialchars($type['type_name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="filterSubtype" class="form-control">
                        <option value="">All Subtypes</option>
                        <?php 
                        mysqli_data_seek($subtypes, 0);
                        while ($sub = mysqli_fetch_assoc($subtypes)): ?>
                            <option value="<?php echo htmlspecialchars($sub['subtype_name']); ?>"><?php echo htmlspecialchars($sub['subtype_name']); ?></option>
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
                    <?php foreach ($items as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['serial_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['distributed_quantity']); ?></td>
                            <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['type_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['subtype_name']); ?></td>
                            <td>
                                <button class="btn btn-unit btn-sm" data-bs-toggle="modal" data-bs-target="#repairRequestModal<?php echo $row['item_id']; ?>" title="Request Repair">
                                    <i class="bi bi-tools"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Repair Request Modal -->
                        <div class="modal fade" id="repairRequestModal<?php echo $row['item_id']; ?>" tabindex="-1" aria-labelledby="repairRequestModalLabel<?php echo $row['item_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="repairRequestModalLabel<?php echo $row['item_id']; ?>">Request Repair for <?php echo htmlspecialchars($row['item_name']); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="process_repair_request.php" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
                                            <input type="hidden" name="unit_id" value="<?php echo $unitid; ?>">
                                            <div class="mb-3">
                                                <label for="reason<?php echo $row['item_id']; ?>" class="form-label">Reason for Repair</label>
                                                <textarea class="form-control" id="reason<?php echo $row['item_id']; ?>" name="reason" rows="4" required placeholder="Describe the issue..."></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="image<?php echo $row['item_id']; ?>" class="form-label">Upload Image of Damage (Optional)</label>
                                                <input type="file" class="form-control" id="image<?php echo $row['item_id']; ?>" name="image" accept="image/*">
                                            </div>
                                            <button type="submit" class="btn btn-unit">Submit Request</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Filter and Search Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterCategory = document.getElementById('filterCategory');
            const filterType = document.getElementById('filterType');
            const filterSubtype = document.getElementById('filterSubtype');
            const searchInput = document.getElementById('searchInput');
            const table = document.getElementById('inventoryTable');
            const rows = table.getElementsByTagName('tr');

            function filterTable() {
                const category = filterCategory.value.toLowerCase();
                const type = filterType.value.toLowerCase();
                const subtype = filterSubtype.value.toLowerCase();
                const search = searchInput.value.toLowerCase();

                for (let i = 1; i < rows.length; i++) {
                    const row = rows[i];
                    const cells = row.getElementsByTagName('td');
                    const name = cells[0].textContent.toLowerCase();
                    const description = cells[1].textContent.toLowerCase();
                    const serial = cells[2].textContent.toLowerCase();
                    const rowCategory = cells[4].textContent.toLowerCase();
                    const rowType = cells[5].textContent.toLowerCase();
                    const rowSubtype = cells[6].textContent.toLowerCase();

                    const matchesCategory = !category || rowCategory === category;
                    const matchesType = !type || rowType === type;
                    const matchesSubtype = !subtype || rowSubtype === subtype;
                    const matchesSearch = !search || name.includes(search) || description.includes(search) || serial.includes(search);

                    row.style.display = matchesCategory && matchesType && matchesSubtype && matchesSearch ? '' : 'none';
                }
            }

            filterCategory.addEventListener('change', filterTable);
            filterType.addEventListener('change', filterTable);
            filterSubtype.addEventListener('change', filterTable);
            searchInput.addEventListener('input', filterTable);
        });
    </script>