<?php
session_start();
 $unitid = $_SESSION['unitin_id'];
 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayubowan Health - Unit Incharge Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     <link href="sub_style.css" rel="stylesheet">
     
</head>
<body>
    <!-- Unit Header -->
   <?php
      include('header.php');
   ?>
      
    
    <!-- Navigation -->
    <div class="container-fluid">
        <div class="nav-unit">
           <a class="nav-link active" href="#">
                <i class="bi bi-tools me-2"></i>Request Repair
            </a>
            <a class="nav-link" href="#">
                <i class="bi bi-table me-2"></i>Repair Records
            </a>

           
        </div>
    </div>
    
    <!-- Dashboard Content -->
    <div class="container-fluid dashboard-content">
        <div class="row">
            
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
                        item_distributions.unit_id = $unitid && inventory_item.category_id != 2 ;
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
                    
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['item_name']) ?></td>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td><?= htmlspecialchars($row['serial_number']) ?></td>
                            <td><?= htmlspecialchars($row['distributed_quantity']) ?></td>
                            <td><?= htmlspecialchars($row['category_name']) ?></td>
                            <td><?= htmlspecialchars($row['type_name']) ?></td>
                            <td><?= htmlspecialchars($row['subtype_name']) ?></td>
                    
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                        </div>
                    </div>
                </div>
       </div>  
    </div>   
</body>
</html>