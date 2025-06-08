<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayubowan Health - Unit Incharge Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #1a76d2;
            --secondary: #2e7d32;
            --accent: #ff6f00;
            --light-bg: #f8f9fa;
            --dark-text: #2c3e50;
            --unit-blue: #1976d2;
            --unit-green: #388e3c;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f7ff;
            color: var(--dark-text);
            overflow-x: hidden;
        }
        
        .unit-header {
            background: linear-gradient(120deg, var(--unit-blue), var(--unit-green));
            color: white;
            padding: 25px 30px;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .unit-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .unit-icon {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
        }
        
        .unit-title h2 {
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .unit-title p {
            margin-bottom: 0;
            opacity: 0.9;
        }
        
        .unit-stats {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }
        
        .unit-stat {
            background: rgba(255,255,255,0.15);
            border-radius: 15px;
            padding: 15px 20px;
            text-align: center;
            flex: 1;
            backdrop-filter: blur(5px);
        }
        
        .unit-stat h3 {
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 28px;
        }
        
        .unit-stat p {
            margin-bottom: 0;
            font-size: 14px;
        }
        
        .dashboard-content {
            padding: 0 30px 30px;
        }
        
        .card-unit {
            background: white;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            border: none;
            margin-bottom: 25px;
            transition: all 0.3s;
            border-top: 4px solid var(--unit-blue);
        }
        
        .card-unit:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .card-header-unit {
            background: rgba(25, 118, 210, 0.05);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 15px 20px;
            border-radius: 15px 15px 0 0 !important;
            font-weight: 600;
            color: var(--unit-blue);
        }
        
        .card-body-unit {
            padding: 20px;
        }
        
        .unit-section-title {
            position: relative;
            padding-left: 15px;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--unit-blue);
        }
        
        .unit-section-title:before {
            content: '';
            position: absolute;
            left: 0;
            top: 5px;
            height: 20px;
            width: 5px;
            background: var(--unit-blue);
            border-radius: 10px;
        }
        
        .patient-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .patient-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        
        .patient-item:last-child {
            border-bottom: none;
        }
        
        .patient-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--unit-blue), var(--unit-green));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 18px;
            flex-shrink: 0;
            margin-right: 15px;
        }
        
        .patient-info {
            flex: 1;
        }
        
        .patient-name {
            font-weight: 600;
            margin-bottom: 3px;
        }
        
        .patient-meta {
            display: flex;
            gap: 15px;
            font-size: 13px;
            color: #6c757d;
        }
        
        .med-status {
            font-size: 12px;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 500;
        }
        
        .status-pending {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
        }
        
        .status-completed {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }
        
        .inventory-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0f4f8;
        }
        
        .inventory-item:last-child {
            border-bottom: none;
        }
        
        .inventory-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(25, 118, 210, 0.1);
            color: var(--unit-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .inventory-info {
            flex: 1;
        }
        
        .inventory-name {
            font-weight: 500;
            margin-bottom: 3px;
        }
        
        .inventory-meta {
            display: flex;
            gap: 15px;
            font-size: 13px;
            color: #6c757d;
        }
        
        .stock-level {
            height: 8px;
            border-radius: 4px;
            background: #e9ecef;
            overflow: hidden;
            margin-top: 8px;
        }
        
        .stock-progress {
            height: 100%;
            background: var(--unit-blue);
            border-radius: 4px;
        }
        
        .critical .stock-progress {
            background: #dc3545;
        }
        
        .low .stock-progress {
            background: #ffc107;
        }
        
        .btn-unit {
            background: var(--unit-blue);
            border-color: var(--unit-blue);
            color: white;
            border-radius: 10px;
            padding: 8px 20px;
            font-weight: 500;
        }
        
        .btn-unit:hover {
            background: #1565c0;
            border-color: #1565c0;
            color: white;
        }
        
        .btn-unit-outline {
            border-color: var(--unit-blue);
            color: var(--unit-blue);
            border-radius: 10px;
            padding: 8px 20px;
            font-weight: 500;
        }
        
        .btn-unit-outline:hover {
            background: var(--unit-blue);
            color: white;
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(25, 118, 210, 0.1);
            color: var(--unit-blue);
            border: none;
            transition: all 0.3s;
        }
        
        .action-btn:hover {
            background: var(--unit-blue);
            color: white;
            transform: scale(1.05);
        }
        
        .nav-unit {
            background: white;
            border-radius: 15px;
            padding: 10px;
            display: flex;
            margin-bottom: 25px;
            box-shadow: var(--card-shadow);
        }
        
        .nav-unit .nav-link {
            flex: 1;
            text-align: center;
            padding: 12px;
            border-radius: 10px;
            color: #6c757d;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .nav-unit .nav-link.active {
            background: rgba(25, 118, 210, 0.1);
            color: var(--unit-blue);
        }
        
        @media (max-width: 768px) {
            .unit-stats {
                flex-direction: column;
                gap: 10px;
            }
            
            .dashboard-content {
                padding: 0 15px 30px;
            }
            
            .nav-unit {
                flex-wrap: wrap;
            }
            
            .nav-unit .nav-link {
                flex: 0 0 50%;
                margin-bottom: 5px;
            }
        }
        
        .badge-unit {
            background: rgba(25, 118, 210, 0.1);
            color: var(--unit-blue);
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 13px;
        }
        
        .qa-card {
            border-left: 4px solid var(--accent);
        }
        
        .qa-card .card-header-unit {
            color: var(--accent);
        }
    </style>
</head>
<body>
    <!-- Unit Header -->
    <header class="unit-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="unit-info">
                    <div class="unit-icon">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                    <div class="unit-title">
                        <h2>Emergency Unit</h2>
                        <p>Ayubowan Health - Colombo</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <div class="position-relative">
                        <button class="btn btn-light position-relative">
                            <i class="bi bi-bell fs-5"></i>
                            <span class="notification-badge">3</span>
                        </button>
                    </div>
                    <div class="dropdown">
                        <div class="d-flex align-items-center" data-bs-toggle="dropdown">
                            <div class="user-avatar">NU</div>
                            <div class="ms-2">
                                <p class="mb-0 fw-medium">Nimali Perera</p>
                                <small>Unit Incharge</small>
                            </div>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
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
        </div>
    </header>
    
    <!-- Navigation -->
    <div class="container-fluid">
        <div class="nav-unit">
            <a class="nav-link active" href="#"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
            <a class="nav-link" href="#"><i class="bi bi-clipboard-pulse me-2"></i> Patient Care</a>
            <a class="nav-link" href="#"><i class="bi bi-capsule me-2"></i> Medications</a>
            <a class="nav-link" href="#"><i class="bi bi-box-seam me-2"></i> Inventory</a>
            <a class="nav-link" href="#"><i class="bi bi-clipboard-check me-2"></i> Quality Control</a>
            <a class="nav-link" href="#"><i class="bi bi-file-earmark-text me-2"></i> Reports</a>
        </div>
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

    <script>
        // Initialize charts when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Medication Schedule Chart
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