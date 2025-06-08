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
   
</head>
<body>
    <!-- Sidebar -->
   <?php include('slide_bar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
           <?php include('header.php') ?>
     <div class="unit-header">   
        <div class="unit-stats">
                <div class="unit-stat">
                    <h3>24</h3>
                    <p>Current Patients</p>
                </div>
                <div class="unit-stat">
                    <h3>18</h3>
                    <p>Active Medications</p>
                </div>
                <div class="unit-stat">
                    <h3>5</h3>
                    <p>Low Stock Items</p>
                </div>
                <div class="unit-stat">
                    <h3>12</h3>
                    <p>Pending Requests</p>
                </div>
            </div>

            <?php  echo $unitid;  ?>
</div>
        <!-- Dashboard Content -->
        <div class="container-fluid dashboard-content">
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- Patient Medication Tracking -->
                    <div class="card card-unit">
                        <div class="card-header-unit">
                            <i class="bi bi-clipboard-pulse me-2"></i> Patient Medication Schedule
                        </div>
                        <div class="card-body-unit">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="unit-section-title">Today's Medication Schedule</h4>
                                <button class="btn btn-unit-outline"><i class="bi bi-plus-circle me-1"></i> New Schedule</button>
                            </div>
                            <ul class="patient-list">
                                <li class="patient-item">
                                    <div class="patient-avatar">RS</div>
                                    <div class="patient-info">
                                        <div class="patient-name">Ravi Silva</div>
                                        <div class="patient-meta">
                                            <span>Bed 05</span>
                                            <span>ID: P-10245</span>
                                            <span>Critical Care</span>
                                        </div>
                                    </div>
                                    <div class="med-status status-pending">2 Pending</div>
                                    <button class="action-btn ms-2"><i class="bi bi-clipboard-check"></i></button>
                                </li>
                                <li class="patient-item">
                                    <div class="patient-avatar">KP</div>
                                    <div class="patient-info">
                                        <div class="patient-name">Kamala Perera</div>
                                        <div class="patient-meta">
                                            <span>Bed 12</span>
                                            <span>ID: P-10248</span>
                                            <span>Post-Op Recovery</span>
                                        </div>
                                    </div>
                                    <div class="med-status status-completed">Completed</div>
                                    <button class="action-btn ms-2"><i class="bi bi-clipboard-check"></i></button>
                                </li>
                                <li class="patient-item">
                                    <div class="patient-avatar">SJ</div>
                                    <div class="patient-info">
                                        <div class="patient-name">Sarath Jayasuriya</div>
                                        <div class="patient-meta">
                                            <span>Bed 08</span>
                                            <span>ID: P-10252</span>
                                            <span>Cardiac Monitoring</span>
                                        </div>
                                    </div>
                                    <div class="med-status status-pending">3 Pending</div>
                                    <button class="action-btn ms-2"><i class="bi bi-clipboard-check"></i></button>
                                </li>
                                <li class="patient-item">
                                    <div class="patient-avatar">MD</div>
                                    <div class="patient-info">
                                        <div class="patient-name">Malini Dias</div>
                                        <div class="patient-meta">
                                            <span>Bed 03</span>
                                            <span>ID: P-10249</span>
                                            <span>Respiratory Care</span>
                                        </div>
                                    </div>
                                    <div class="med-status status-pending">1 Pending</div>
                                    <button class="action-btn ms-2"><i class="bi bi-clipboard-check"></i></button>
                                </li>
                            </ul>
                            <div class="mt-4">
                                <canvas id="medicationChart" height="150"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Unit Inventory Status -->
                    <div class="card card-unit">
                        <div class="card-header-unit">
                            <i class="bi bi-box-seam me-2"></i> Unit Inventory Status
                        </div>
                        <div class="card-body-unit">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="unit-section-title">Critical Inventory Items</h4>
                                <button class="btn btn-unit"><i class="bi bi-cart-plus me-1"></i> Request Items</button>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="inventory-item critical">
                                        <div class="inventory-icon">
                                            <i class="bi bi-capsule"></i>
                                        </div>
                                        <div class="inventory-info">
                                            <div class="inventory-name">Paracetamol 500mg</div>
                                            <div class="inventory-meta">
                                                <span>Current: 24</span>
                                                <span>Min: 50</span>
                                            </div>
                                            <div class="stock-level">
                                                <div class="stock-progress" style="width: 48%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="inventory-item">
                                        <div class="inventory-icon">
                                            <i class="bi bi-droplet"></i>
                                        </div>
                                        <div class="inventory-info">
                                            <div class="inventory-name">Saline Solution 500ml</div>
                                            <div class="inventory-meta">
                                                <span>Current: 42</span>
                                                <span>Min: 30</span>
                                            </div>
                                            <div class="stock-level">
                                                <div class="stock-progress" style="width: 85%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="inventory-item critical">
                                        <div class="inventory-icon">
                                            <i class="bi bi-prescription"></i>
                                        </div>
                                        <div class="inventory-info">
                                            <div class="inventory-name">Insulin Syringes</div>
                                            <div class="inventory-meta">
                                                <span>Current: 18</span>
                                                <span>Min: 40</span>
                                            </div>
                                            <div class="stock-level">
                                                <div class="stock-progress" style="width: 45%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="inventory-item low">
                                        <div class="inventory-icon">
                                            <i class="bi bi-bandage"></i>
                                        </div>
                                        <div class="inventory-info">
                                            <div class="inventory-name">Surgical Dressings</div>
                                            <div class="inventory-meta">
                                                <span>Current: 32</span>
                                                <span>Min: 50</span>
                                            </div>
                                            <div class="stock-level">
                                                <div class="stock-progress" style="width: 64%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <button class="btn btn-unit-outline"><i class="bi bi-arrow-repeat me-1"></i> Refresh Inventory</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Quick Actions -->
                    <div class="card card-unit">
                        <div class="card-header-unit">
                            <i class="bi bi-lightning me-2"></i> Quick Actions
                        </div>
                        <div class="card-body-unit">
                            <div class="row g-3">
                                <div class="col-6">
                                    <button class="btn btn-unit w-100 py-3">
                                        <i class="bi bi-cart-plus fs-4 d-block mb-2"></i>
                                        Request Supplies
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-unit w-100 py-3">
                                        <i class="bi bi-clipboard-check fs-4 d-block mb-2"></i>
                                        Mark Medication
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-unit w-100 py-3">
                                        <i class="bi bi-file-earmark-medical fs-4 d-block mb-2"></i>
                                        New Report
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-unit w-100 py-3">
                                        <i class="bi bi-tools fs-4 d-block mb-2"></i>
                                        Report Repair
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-unit w-100 py-3">
                                        <i class="bi bi-exclamation-triangle fs-4 d-block mb-2"></i>
                                        Quality Issue
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-unit w-100 py-3">
                                        <i class="bi bi-person-plus fs-4 d-block mb-2"></i>
                                        Admit Patient
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quality Control -->
                    <div class="card card-unit qa-card">
                        <div class="card-header-unit">
                            <i class="bi bi-clipboard-check me-2"></i> Quality Control
                        </div>
                        <div class="card-body-unit">
                            <h4 class="unit-section-title">Recent Quality Reports</h4>
                            <div class="alert alert-warning d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle me-2 fs-4"></i>
                                <div>2 pending quality issues require your attention</div>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-medium">Paracetamol Batch #B245</div>
                                        <small class="text-muted">Reported: 2 hours ago</small>
                                    </div>
                                    <span class="badge-unit">Pending</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-medium">Insulin Syringes</div>
                                        <small class="text-muted">Reported: Yesterday</small>
                                    </div>
                                    <span class="badge bg-success bg-opacity-10 text-success">Resolved</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-medium">Ventilator Calibration</div>
                                        <small class="text-muted">Reported: May 25</small>
                                    </div>
                                    <span class="badge bg-success bg-opacity-10 text-success">Resolved</span>
                                </li>
                            </ul>
                            <button class="btn btn-unit w-100 mt-3">
                                <i class="bi bi-plus-circle me-1"></i> Submit Quality Report
                            </button>
                        </div>
                    </div>

                    <!-- Distribution Status -->
                    <div class="card card-unit">
                        <div class="card-header-unit">
                            <i class="bi bi-truck me-2"></i> Distribution Status
                        </div>
                        <div class="card-body-unit">
                            <h4 class="unit-section-title">Recent Distributions</h4>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-check2-circle"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Medical Supplies Delivery</h6>
                                    <p class="text-muted mb-0">Completed at 10:30 AM</p>
                                    <small class="text-muted">Received 24 items</small>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Pharmaceutical Order</h6>
                                    <p class="text-muted mb-0">In transit - ETA 3:00 PM</p>
                                    <small class="text-muted">15 medication items</small>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Surgical Equipment</h6>
                                    <p class="text-muted mb-0">Processing - Expected tomorrow</p>
                                    <small class="text-muted">8 surgical items</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const medCtx = document.getElementById('medicationChart').getContext('2d');
            const medChart = new Chart(medCtx, {
                type: 'bar',
                data: {
                    labels: ['6 AM', '9 AM', '12 PM', '3 PM', '6 PM', '9 PM'],
                    datasets: [{
                        label: 'Scheduled Medications',
                        data: [12, 18, 8, 14, 10, 6],
                        backgroundColor: 'rgba(25, 118, 210, 0.7)',
                        borderColor: 'rgba(25, 118, 210, 1)',
                        borderWidth: 1,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            },
                            title: {
                                display: true,
                                text: 'Number of Medications'
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
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>