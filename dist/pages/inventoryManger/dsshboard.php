<?php
      // dashboard.php
      session_start();
      if (!isset($_SESSION['user_id'])) {
          header("Location: login.php");
          exit;
      }
 ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HIMS </title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128+Text&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
           <?php include('Slidebari.php'); ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">
                <!-- Header -->
                   <?php include('Header.php'); ?>

                <!-- Stats Cards -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="card-body">
                                <div class="card-icon green">
                                    <i class="bi bi-capsule"></i>
                                </div>
                                <h2>2,148</h2>
                                <p class="text-muted mb-0">Total Items</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="card-body">
                                <div class="card-icon orange">
                                    <i class="bi bi-exclamation-triangle"></i>
                                </div>
                                <h2>68</h2>
                                <p class="text-muted mb-0">Low Stock Items</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="card-body">
                                <div class="card-icon green">
                                    <i class="bi bi-cart-check"></i>
                                </div>
                                <h2>24</h2>
                                <p class="text-muted mb-0">Pending Orders</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="card-body">
                                <div class="card-icon blue">
                                    <i class="bi bi-tools"></i>
                                </div>
                                <h2>15</h2>
                                <p class="text-muted mb-0">Active Repairs</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Features Section -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="feature-card text-center">
                            <div class="feature-icon">
                                <i class="bi bi-upc-scan"></i>
                            </div>
                            <h5>Barcode Management</h5>
                            <p>Generate and manage barcodes for all inventory items with automatic system generation</p>
                            
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="feature-card text-center">
                            <div class="feature-icon">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <h5>Procurement Prediction</h5>
                            <p>AI-powered demand forecasting based on historical usage and patient trends</p>
                            <div class="mt-3">
                                <small class="text-muted">Predicted demand for next month:</small>
                                <div class="progress mt-2" style="height: 10px;">
                                    <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="feature-card text-center">
                            <div class="feature-icon">
                                <i class="bi bi-clipboard-check"></i>
                            </div>
                            <h5>Quality Control</h5>
                            <p>Drug quality management with batch tracking and complaint resolution</p>
                            <div class="mt-3">
                                <span class="badge bg-success">Active QA: 12</span>
                                <span class="badge bg-warning ms-2">Pending: 5</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table with item status -->
             <div class="tabs-container">
                <?php
                include('db_connect.php');


                $query = "
                    SELECT 
                        inventory_item.*,
                        inventory_category.category_name,
                        inventory_type.type_name,
                        inventory_subtype.subtype_name,
                        item_approvals.approved_quantity,
                        item_approvals.comment,
                        inventory_item.quantity AS current_quantity
                    FROM inventory_item
                    JOIN inventory_category ON inventory_item.category_id = inventory_category.category_id
                    JOIN inventory_type ON inventory_item.type_id = inventory_type.type_id
                    JOIN inventory_subtype ON inventory_item.subtype_id = inventory_subtype.subtype_id
                    LEFT JOIN item_approvals ON inventory_item.item_id = item_approvals.approval_id
                    WHERE inventory_item.category_id = 2 
                    AND inventory_item.status = 1
                    ORDER BY inventory_item.created_at DESC
                ";

                $result = mysqli_query($conn, $query);

                $items = [];
                $low_inventory_notifications = [];

                while ($row = mysqli_fetch_assoc($result)) {
                    // Inventory level status logic
                    $approved = $row['approved_quantity'];
                    $current = $row['current_quantity'];
                    $status = 'Normal';

                    if ($approved > 0) {
                        $low_threshold = $approved * 0.2;
                        $medium_threshold = $approved * 0.4;

                        if ($current <= $low_threshold) {
                            $status = 'Low';
                        } elseif ($current <= $medium_threshold) {
                            $status = 'Medium';
                        }
                    }

                    $row['inventory_status'] = $status;

                    if ($status !== 'Normal') {
                        $low_inventory_notifications[] = $row; // Store for notification panel
                    }

                    $items[] = $row; 
                }
                ?>

                <!-- Inventory Table UI -->
                <div class="tabs-container">
                    <table class="table table-bordered table-striped" id="inventoryTable">
                        <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                      
                            
                            <th>Qty</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Subtype</th>
                            <th>Status</th>
                         
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($items as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['item_name']) ?></td>
                              
                            
                                <td><?= htmlspecialchars($row['current_quantity']) ?></td>
                                <td><?= htmlspecialchars($row['category_name']) ?></td>
                                <td><?= htmlspecialchars($row['type_name']) ?></td>
                                <td><?= htmlspecialchars($row['subtype_name']) ?></td>
                                <td>
                                    <?php
                                        if ($row['inventory_status'] == 'Low') {
                                            echo '<span class="badge badge-danger">Low</span>';
                                        } elseif ($row['inventory_status'] == 'Medium') {
                                            echo '<span class="badge badge-warning">Medium</span>';
                                        } else {
                                            echo '<span class="badge badge-success">Normal</span>';
                                        }
                                    ?>
                                </td>
                               
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Optional: Admin Notification Section -->
                <?php if (!empty($low_inventory_notifications)): ?>
                <div class="alert alert-warning mt-3">
                    <strong>⚠️ Inventory Alerts:</strong>
                    <ul>
                        <?php foreach ($low_inventory_notifications as $item): ?>
                            <li>
                                <?= htmlspecialchars($item['item_name']) ?> has <strong><?= $item['inventory_status'] ?></strong> level quantity: 
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>


                </div>


                <!-- Repair Management -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-container">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="section-title mb-0">Repair Management</h4>
                                <button class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i> New Repair Request</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Item ID</th>
                                            <th>Item Name</th>
                                            <th>Unit</th>
                                            <th>Problem</th>
                                            <th>Request Date</th>
                                            <th>Status</th>
                                            <th>Progress</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>EQ-102</td>
                                            <td>Patient Monitor</td>
                                            <td>ICU</td>
                                            <td>Display malfunction</td>
                                            <td>2023-05-15</td>
                                            <td><span class="badge bg-warning">In Progress</span></td>
                                            <td>
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar" role="progressbar" style="width: 60%;"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>EQ-245</td>
                                            <td>Infusion Pump</td>
                                            <td>Ward 5</td>
                                            <td>Calibration needed</td>
                                            <td>2023-05-18</td>
                                            <td><span class="badge bg-info">Pending Approval</span></td>
                                            <td>
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar" role="progressbar" style="width: 30%;"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>EQ-078</td>
                                            <td>Ventilator</td>
                                            <td>Emergency</td>
                                            <td>Motor replacement</td>
                                            <td>2023-05-10</td>
                                            <td><span class="badge bg-success">Completed</span></td>
                                            <td>
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar" role="progressbar" style="width: 100%;"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Notifications</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Low Stock Alert</h6>
                                <small>5 min ago</small>
                            </div>
                            <p class="mb-1">Paracetamol 500mg stock is critical (120/200)</p>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">New Order Received</h6>
                                <small>1 hour ago</small>
                            </div>
                            <p class="mb-1">Order #ORD-1032 from Pharma Lanka Ltd.</p>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Repair Completed</h6>
                                <small>3 hours ago</small>
                            </div>
                            <p class="mb-1">Ventilator EQ-078 repair completed</p>
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Initialize charts and filter functionality when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Usage Trend Chart
            const usageCtx = document.getElementById('usageChart').getContext('2d');
            const usageChart = new Chart(usageCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Paracetamol 500mg',
                        data: [320, 290, 350, 410, 380, 360],
                        borderColor: '#1a76d2',
                        backgroundColor: 'rgba(26, 118, 210, 0.1)',
                        tension: 0.3,
                        fill: true
                    }, {
                        label: 'Insulin Syringes',
                        data: [180, 210, 190, 230, 250, 210],
                        borderColor: '#43a047',
                        backgroundColor: 'rgba(67, 160, 71, 0.1)',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            grid: {
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Vendor Price Comparison Chart
            const vendorCtx = document.getElementById('vendorChart').getContext('2d');
            const vendorChart = new Chart(vendorCtx, {
                type: 'bar',
                data: {
                    labels: ['Paracetamol', 'Surgical Gloves', 'Antibiotic Oint', 'Insulin Syringes'],
                    datasets: [
                        {
                            label: 'Pharma Lanka',
                            data: [12.5, 8.2, 15.7, 22.3],
                            backgroundColor: 'rgba(46, 125, 50, 0.7)',
                        },
                        {
                            label: 'MedEquip',
                            data: [13.2, 8.5, 16.8, 24.1],
                            backgroundColor: 'rgba(255, 111, 0, 0.7)',
                        },
                        {
                            label: 'Surgical Care',
                            data: [14.0, 7.8, 17.2, 23.5],
                            backgroundColor: 'rgba(26, 118, 210, 0.7)',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Price per Unit (LKR)'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            }
                        }
                    }
                }
            });

            // Category Filter for Stock Table
            const categoryFilter = document.getElementById('categoryFilter');
            const stockTable = document.getElementById('stockTable');
            const rows = stockTable.querySelectorAll('tbody tr');

            categoryFilter.addEventListener('change', function() {
                const selectedCategory = this.value;

                rows.forEach(row => {
                    const rowCategory = row.getAttribute('data-category');
                    if (selectedCategory === 'all' || rowCategory === selectedCategory) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });

        
    </script>
</body>
</html>