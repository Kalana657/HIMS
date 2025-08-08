<?php
      // dashboard.php
      session_start();
      if (!isset($_SESSION['user_id'])) {
          header("Location: ../../../index.php");
          exit;
      }
 ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HIMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <link href="adminstyle.css" rel="stylesheet">
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
     <?php
       include('Slide_bar.php');

     ?>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Topbar -->
           <?php
             include('Topbar.php');

           ?>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card fade-in">
                    <div class="stat-icon">
                        <i class="bi bi-capsule"></i>
                    </div>
                    <div class="stat-content">
                        <h2>2,148</h2>
                        <p>Total Inventory Items</p>
                        <div class="stat-trend trend-up">
                            <i class="bi bi-arrow-up"></i> 12% from last month
                        </div>
                    </div>
                </div>
                
                <div class="stat-card fade-in delay-1">
                    <div class="stat-icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div class="stat-content">
                        <h2>68</h2>
                        <p>Low Stock Items</p>
                        <div class="stat-trend trend-down">
                            <i class="bi bi-arrow-down"></i> 5% from last week
                        </div>
                    </div>
                </div>
                
                <div class="stat-card fade-in delay-2">
                    <div class="stat-icon">
                        <i class="bi bi-cart"></i>
                    </div>
                    <div class="stat-content">
                        <h2>24</h2>
                        <p>Pending Orders</p>
                        <div class="stat-trend trend-up">
                            <i class="bi bi-arrow-up"></i> 8% from yesterday
                        </div>
                    </div>
                </div>
                
                <div class="stat-card fade-in delay-3">
                    <div class="stat-icon">
                        <i class="bi bi-currency-exchange"></i>
                    </div>
                    <div class="stat-content">
                        <h2>LKR 1.2M</h2>
                        <p>Monthly Inventory Value</p>
                        <div class="stat-trend trend-up">
                            <i class="bi bi-arrow-up"></i> 15% from last month
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="quick-stat fade-in delay-1">
                    <div class="quick-stat-icon">
                        <i class="bi bi-upc-scan"></i>
                    </div>
                    <div class="quick-stat-content">
                        <h3>128</h3>
                        <p>Barcodes Generated</p>
                    </div>
                </div>
                
                <div class="quick-stat fade-in delay-2">
                    <div class="quick-stat-icon">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <div class="quick-stat-content">
                        <h3>42</h3>
                        <p>Quality Checks</p>
                    </div>
                </div>
                
                <div class="quick-stat fade-in delay-3">
                    <div class="quick-stat-icon">
                        <i class="bi bi-tools"></i>
                    </div>
                    <div class="quick-stat-content">
                        <h3>15</h3>
                        <p>Active Repairs</p>
                    </div>
                </div>
                
                <div class="quick-stat fade-in delay-4">
                    <div class="quick-stat-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="quick-stat-content">
                        <h3>28</h3>
                        <p>Active Vendors</p>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="chart-row">
                <div class="chart-container fade-in">
                    <div class="section-header">
                        <h3 class="section-title">Inventory Analytics</h3>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-secondary">Day</button>
                            <button class="btn btn-sm btn-outline-secondary active">Week</button>
                            <button class="btn btn-sm btn-outline-secondary">Month</button>
                            <button class="btn btn-sm btn-outline-secondary">Year</button>
                        </div>
                    </div>
                    <canvas id="inventoryChart" height="300"></canvas>
                </div>
                
                <div class="chart-container fade-in delay-1">
                    <div class="section-header">
                        <h3 class="section-title">Stock Distribution</h3>
                    </div>
                    <canvas id="distributionChart" height="300"></canvas>
                </div>
            </div>

            <!-- Tables Row -->
            <div class="row">
                <div class="col-md-8">
                    <div class="table-container fade-in">
                        <div class="table-header">
                            <h3 class="section-title">Low Stock Items</h3>
                            <button class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i> Add New Item
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th>Item ID</th>
                                        <th>Item Name</th>
                                        <th>Category</th>
                                        <th>Current Stock</th>
                                        <th>Threshold</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>MED-001</td>
                                        <td>Paracetamol 500mg</td>
                                        <td>Pharmaceutical</td>
                                        <td>120</td>
                                        <td>200</td>
                                        <td><span class="status-badge badge-warning">Low Stock</span></td>
                                        <td>
                                            <button class="action-btn me-1"><i class="bi bi-cart-plus"></i></button>
                                            <button class="action-btn me-1"><i class="bi bi-pencil"></i></button>
                                            <button class="action-btn"><i class="bi bi-upc-scan"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>SUR-045</td>
                                        <td>Surgical Gloves (M)</td>
                                        <td>Surgical</td>
                                        <td>85</td>
                                        <td>150</td>
                                        <td><span class="status-badge badge-danger">Critical</span></td>
                                        <td>
                                            <button class="action-btn me-1"><i class="bi bi-cart-plus"></i></button>
                                            <button class="action-btn me-1"><i class="bi bi-pencil"></i></button>
                                            <button class="action-btn"><i class="bi bi-upc-scan"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>MED-112</td>
                                        <td>Insulin Syringes 1ml</td>
                                        <td>Medical Equipment</td>
                                        <td>210</td>
                                        <td>250</td>
                                        <td><span class="status-badge badge-warning">Low Stock</span></td>
                                        <td>
                                            <button class="action-btn me-1"><i class="bi bi-cart-plus"></i></button>
                                            <button class="action-btn me-1"><i class="bi bi-pencil"></i></button>
                                            <button class="action-btn"><i class="bi bi-upc-scan"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>GEN-008</td>
                                        <td>Disinfectant Wipes</td>
                                        <td>General</td>
                                        <td>95</td>
                                        <td>200</td>
                                        <td><span class="status-badge badge-danger">Critical</span></td>
                                        <td>
                                            <button class="action-btn me-1"><i class="bi bi-cart-plus"></i></button>
                                            <button class="action-btn me-1"><i class="bi bi-pencil"></i></button>
                                            <button class="action-btn"><i class="bi bi-upc-scan"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="table-container fade-in delay-1">
                        <div class="table-header">
                            <h3 class="section-title">Recent Activities</h3>
                        </div>
                        <div class="activity-list">
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart-check fs-5"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">New order placed</h6>
                                    <p class="text-muted mb-0">Order #ORD-1028 for 120 Paracetamol</p>
                                    <small class="text-muted">2 hours ago</small>
                                </div>
                            </div>
                            
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-upc-scan fs-5"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">New item added</h6>
                                    <p class="text-muted mb-0">Added "Antibiotic Ointment" to inventory</p>
                                    <small class="text-muted">4 hours ago</small>
                                </div>
                            </div>
                            
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-exclamation-triangle fs-5"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Low stock alert</h6>
                                    <p class="text-muted mb-0">Surgical Gloves stock is critical</p>
                                    <small class="text-muted">6 hours ago</small>
                                </div>
                            </div>
                            
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-clipboard-check fs-5"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">QA approved</h6>
                                    <p class="text-muted mb-0">Batch #BAT-045 passed quality check</p>
                                    <small class="text-muted">Yesterday</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Repair Management -->
            <div class="table-container fade-in delay-2">
                <div class="table-header">
                    <h3 class="section-title">Repair Management</h3>
                    <button class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i> New Repair
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Unit</th>
                                <th>Problem</th>
                                <th>Requested</th>
                                <th>Status</th>
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-2">
                                            <i class="bi bi-heart-pulse fs-4 text-danger"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Patient Monitor</h6>
                                            <small class="text-muted">ID: EQ-102</small>
                                        </div>
                                    </div>
                                </td>
                                <td>ICU</td>
                                <td>Display malfunction</td>
                                <td>May 15, 2023</td>
                                <td><span class="status-badge badge-warning">In Progress</span></td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress-bar" style="width: 60%"></div>
                                    </div>
                                    <small>60% completed</small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-2">
                                            <i class="bi bi-droplet fs-4 text-info"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Infusion Pump</h6>
                                            <small class="text-muted">ID: EQ-245</small>
                                        </div>
                                    </div>
                                </td>
                                <td>Ward 5</td>
                                <td>Calibration needed</td>
                                <td>May 18, 2023</td>
                                <td><span class="status-badge badge-info">Pending Approval</span></td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress-bar" style="width: 30%"></div>
                                    </div>
                                    <small>30% completed</small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-2">
                                            <i class="bi bi-lungs fs-4 text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Ventilator</h6>
                                            <small class="text-muted">ID: EQ-078</small>
                                        </div>
                                    </div>
                                </td>
                                <td>Emergency</td>
                                <td>Motor replacement</td>
                                <td>May 10, 2023</td>
                                <td><span class="status-badge badge-success">Completed</span></td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress-bar" style="width: 100%"></div>
                                    </div>
                                    <small>Completed</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize charts when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Inventory Analytics Chart
            const inventoryCtx = document.getElementById('inventoryChart').getContext('2d');
            const inventoryChart = new Chart(inventoryCtx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [
                        {
                            label: 'Surgical Items',
                            data: [1200, 1900, 1500, 1800, 2200, 1950, 2300],
                            borderColor: '#1a76d2',
                            backgroundColor: 'rgba(26, 118, 210, 0.1)',
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Pharmaceuticals',
                            data: [800, 1200, 1000, 1100, 900, 1300, 1500],
                            borderColor: '#2e7d32',
                            backgroundColor: 'rgba(46, 125, 50, 0.1)',
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Medical Equipment',
                            data: [500, 700, 600, 800, 750, 900, 1100],
                            borderColor: '#ff6f00',
                            backgroundColor: 'rgba(255, 111, 0, 0.1)',
                            tension: 0.3,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            grid: {
                                drawBorder: false
                            },
                            title: {
                                display: true,
                                text: 'Quantity'
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

            // Stock Distribution Chart
            const distCtx = document.getElementById('distributionChart').getContext('2d');
            const distChart = new Chart(distCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Surgical', 'Pharmaceuticals', 'Equipment', 'General'],
                    datasets: [{
                        data: [35, 25, 20, 20],
                        backgroundColor: [
                            '#1a76d2',
                            '#2e7d32',
                            '#ff6f00',
                            '#6f42c1'
                        ],
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.label}: ${context.parsed}%`;
                                }
                            }
                        }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>