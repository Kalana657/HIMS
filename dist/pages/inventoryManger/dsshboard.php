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
    <title>HHIMS - Hospital Inventory Management</title>
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
                            <div class="barcode mt-3">MED2023SL001245</div>
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

                <!-- Tabs for Inventory Management -->
                <div class="tabs-container">
                    <ul class="nav nav-tabs" id="inventoryTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="add-tab" data-bs-toggle="tab" data-bs-target="#add" type="button" role="tab">Add New Item</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="track-tab" data-bs-toggle="tab" data-bs-target="#track" type="button" role="tab">Real-time Tracking</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="distribute-tab" data-bs-toggle="tab" data-bs-target="#distribute" type="button" role="tab">Distribution</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="vendor-tab" data-bs-toggle="tab" data-bs-target="#vendor" type="button" role="tab">Vendor Management</button>
                        </li>
                    </ul>
                    <div class="tab-content p-3" id="inventoryTabsContent">
                        <div class="tab-pane fade show active" id="add" role="tabpanel">
                            <form>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Item Name</label>
                                        <input type="text" class="form-control" placeholder="Enter item name">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Category</label>
                                        <select class="form-select">
                                            <option selected>Select category</option>
                                            <option value="surgical">Surgical Items</option>
                                            <option value="general">General Items</option>
                                            <option value="pharma">Pharmaceuticals</option>
                                            <option value="equipment">Medical Equipment</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Item Type</label>
                                        <select class="form-select">
                                            <option selected>Select type</option>
                                            <option value="metal">Metals</option>
                                            <option value="furniture">Furniture</option>
                                            <option value="consumable">Consumables</option>
                                            <option value="drug">Drugs</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Initial Quantity</label>
                                        <input type="number" class="form-control" placeholder="Enter quantity">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Unit</label>
                                        <select class="form-select">
                                            <option selected>Select unit</option>
                                            <option value="pcs">Pieces</option>
                                            <option value="box">Boxes</option>
                                            <option value="mg">Milligrams</option>
                                            <option value="ml">Milliliters</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Storage Location</label>
                                        <input type="text" class="form-control" placeholder="Enter storage location">
                                    </div>
                                    <div class="col-12 mt-3">
                                        <button type="submit" class="btn btn-primary">Add Item & Generate Barcode</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="track" role="tabpanel">
                            <div class="alert alert-warning d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <div>Low stock alert: Paracetamol 500mg is below threshold (120/200)</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Filter by Category</label>
                                    <select class="form-select" id="categoryFilter">
                                        <option value="all">All Items</option>
                                        <option value="general">General Items</option>
                                        <option value="surgical">Surgical Items</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Current Stock Levels</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm" id="stockTable">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Category</th>
                                                    <th>Current Stock</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr data-category="general">
                                                    <td>Paracetamol 500mg</td>
                                                    <td>General</td>
                                                    <td>120</td>
                                                    <td><span class="badge bg-danger">Critical</span></td>
                                                </tr>
                                                <tr data-category="surgical">
                                                    <td>Insulin Syringes</td>
                                                    <td>Surgical</td>
                                                    <td>210</td>
                                                    <td><span class="badge bg-warning">Low</span></td>
                                                </tr>
                                                <tr data-category="surgical">
                                                    <td>Surgical Gloves</td>
                                                    <td>Surgical</td>
                                                    <td>350</td>
                                                    <td><span class="badge bg-success">Adequate</span></td>
                                                </tr>
                                                <tr data-category="general">
                                                    <td>Antibiotic Ointment</td>
                                                    <td>General</td>
                                                    <td>90</td>
                                                    <td><span class="badge bg-danger">Critical</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6>Usage Trends</h6>
                                    <canvas id="usageChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="distribute" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Unit Distribution Priority</h6>
                                    <div class="list-group">
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-0">Emergency Unit</h6>
                                                <small class="text-muted">Critical drugs and supplies</small>
                                            </div>
                                            <span class="badge bg-primary">Priority 1</span>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-0">Surgery Department</h6>
                                                <small class="text-muted">Surgical equipment and materials</small>
                                            </div>
                                            <span class="badge bg-primary">Priority 1</span>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-0">Pediatrics Ward</h6>
                                                <small class="text-muted">Children's medications</small>
                                            </div>
                                            <span class="badge bg-secondary">Priority 2</span>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-0">Administration</h6>
                                                <small class="text-muted">General supplies</small>
                                            </div>
                                            <span class="badge bg-secondary">Priority 3</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6>Distribution Status</h6>
                                    <div class="card mt-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-3">
                                                <div>
                                                    <h5 class="card-title">Emergency Unit Supply</h5>
                                                    <p class="card-text">Last updated: Today, 10:30 AM</p>
                                                </div>
                                                <span class="badge bg-success">Completed</span>
                                            </div>
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar" role="progressbar" style="width: 100%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mt-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-3">
                                                <div>
                                                    <h5 class="card-title">Surgery Department</h5>
                                                    <p class="card-text">Last updated: Today, 9:15 AM</p>
                                                </div>
                                                <span class="badge bg-warning">In Progress</span>
                                            </div>
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar" role="progressbar" style="width: 65%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="vendor" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Top Vendors</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Vendor</th>
                                                    <th>Rating</th>
                                                    <th>Delivery Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Pharma Lanka Ltd.</td>
                                                    <td>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                    </td>
                                                    <td>2.1 days</td>
                                                </tr>
                                                <tr>
                                                    <td>MedEquip Suppliers</td>
                                                    <td>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-half text-warning"></i>
                                                    </td>
                                                    <td>3.4 days</td>
                                                </tr>
                                                <tr>
                                                    <td>Surgical Care Lanka</td>
                                                    <td>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                        <i class="bi bi-star text-warning"></i>
                                                    </td>
                                                    <td>4.2 days</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6>Vendor Price Comparison</h6>
                                    <canvas id="vendorChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
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