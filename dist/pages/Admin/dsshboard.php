<?php
      // dashboard.php
      session_start();
      if (!isset($_SESSION['user_id'])) {
          header("Location: login.php");
          exit;
      }
 ?>



<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>HIMS ADMIN | Dashboard</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="../../../dist/css/adminlte.css" />
    <script src="../../../dist/js/adminlte.js"></script>

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
      integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
      crossorigin="anonymous"
    />
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">

  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li>
          </ul>
        
          <ul class="navbar-nav ms-auto">
        
            <li class="nav-item">
              <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="bi bi-search"></i>
              </a>
            </li>
            <!--end::Navbar Search-->
            <!--begin::Messages Dropdown Menu-->
             <?php
             
                include('uperslidebar.php');

             ?>


            <!--end::User Menu Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
        </div>
      
      </nav>

      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <?php

            include('navbarlogo.php');
         ?>     
       
        <!--begin::Sidebar Wrapper-->
        <?php

            include('slidebar.php');
        ?>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">

     



      <div id="page-content-wrapper">
           
            <div class="container-fluid p-4 mt-5 pt-4">
                <div id="dashboard-content" class="content-section active">
                  
                    <h2 class="mt-4 mb-3">Quick Actions</h2>
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card h-100 shadow-sm border-0 text-center">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center p-4">
                                    <i class="fas fa-plus-circle fa-3x text-success mb-3"></i>
                                    <h5 class="card-title">Add New Item</h5>
                                    <p class="card-text text-muted">Quickly add new inventory items to the system.</p>
                                    <button class="btn btn-success mt-auto" data-bs-toggle="modal" data-bs-target="#addItemModal">Add Item</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card h-100 shadow-sm border-0 text-center">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center p-4">
                                    <i class="fas fa-tools fa-3x text-info mb-3"></i>
                                    <h5 class="card-title">Process Repair</h5>
                                    <p class="card-text text-muted">Manage and update status of pending repair requests.</p>
                                    <button class="btn btn-info mt-auto text-white">View Repairs</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card h-100 shadow-sm border-0 text-center">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center p-4">
                                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                    <h5 class="card-title">Review Low Stock</h5>
                                    <p class="card-text text-muted">Identify and address critical low stock items immediately.</p>
                                    <button class="btn btn-warning mt-auto text-white">Check Stock</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card h-100 shadow-sm border-0 text-center">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center p-4">
                                    <i class="fas fa-chart-bar fa-3x text-primary mb-3"></i>
                                    <h5 class="card-title">Generate Report</h5>
                                    <p class="card-text text-muted">Access and customize various inventory reports.</p>
                                    <button class="btn btn-primary mt-auto">Create Report</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2 class="mt-4 mb-3">Overview Statistics</h2>
                    <div class="row g-4 mb-4">
                        <div class="col-lg-4 col-md-6">
                            <div class="card text-white bg-primary shadow-sm h-100">
                                <div class="card-body d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle fa-3x me-3 opacity-75"></i>
                                    <div>
                                        <h5 class="card-title text-uppercase">Low Stock Alerts</h5>
                                        <p class="card-text fs-2 fw-bold" id="low-stock-alerts">15</p>
                                        <a href="#" class="text-white text-decoration-none small">View Details <i class="fas fa-arrow-circle-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card text-white bg-info shadow-sm h-100">
                                <div class="card-body d-flex align-items-center">
                                    <i class="fas fa-tools fa-3x me-3 opacity-75"></i>
                                    <div>
                                        <h5 class="card-title text-uppercase">Pending Repairs</h5>
                                        <p class="card-text fs-2 fw-bold" id="pending-repairs">7</p>
                                        <a href="#" class="text-white text-decoration-none small">View Details <i class="fas fa-arrow-circle-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card text-white bg-danger shadow-sm h-100">
                                <div class="card-body d-flex align-items-center">
                                    <i class="fas fa-flask fa-3x me-3 opacity-75"></i>
                                    <div>
                                        <h5 class="card-title text-uppercase">Drug Quality Claims</h5>
                                        <p class="card-text fs-2 fw-bold" id="quality-claims">3</p>
                                        <a href="#" class="text-white text-decoration-none small">View Details <i class="fas fa-arrow-circle-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card text-dark bg-light shadow-sm h-100">
                                <div class="card-body d-flex align-items-center">
                                    <i class="fas fa-dollar-sign fa-3x me-3 text-success opacity-75"></i>
                                    <div>
                                        <h5 class="card-title text-uppercase">Total Inventory Value</h5>
                                        <p class="card-text fs-2 fw-bold" id="total-inventory-value">$1.2M</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card text-dark bg-light shadow-sm h-100">
                                <div class="card-body d-flex align-items-center">
                                    <i class="fas fa-users fa-3x me-3 text-secondary opacity-75"></i>
                                    <div>
                                        <h5 class="card-title text-uppercase">Active Users</h5>
                                        <p class="card-text fs-2 fw-bold" id="active-users">24</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card text-dark bg-light shadow-sm h-100">
                                <div class="card-body d-flex align-items-center">
                                    <i class="fas fa-calendar-alt fa-3x me-3 text-primary opacity-75"></i>
                                    <div>
                                        <h5 class="card-title text-uppercase">Last Procurement</h5>
                                        <p class="card-text fs-2 fw-bold" id="last-procurement">May 28, 2025</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4 mt-4">
                        <div class="col-lg-7">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-dark text-white border-0 py-3">
                                    <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Overall Inventory Usage Trend</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="overallUsageChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-dark text-white border-0 py-3">
                                    <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Repair Status Distribution</h5>
                                </div>
                                <div class="card-body d-flex justify-content-center align-items-center">
                                    <canvas id="repairStatusChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2 class="mt-5 mb-3">Critical Stock Overview</h2>
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-dark text-white border-0 py-3">
                            <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Real-time Surgical Drug Stock (Top Critical)</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>Drug Name</th>
                                            <th>Current Stock</th>
                                            <th>Est. Days Left</th>
                                            <th>Usage Trend</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Fentanyl Citrate Inj.</td>
                                            <td><span class="badge bg-warning text-dark p-2">12 vials</span></td>
                                            <td><span class="badge bg-warning p-2">7 days</span></td>
                                            <td><canvas id="fentanylUsageChart" width="100" height="30"></canvas></td>
                                            <td><button class="btn btn-sm btn-outline-primary">Order Now</button></td>
                                        </tr>
                                        <tr>
                                            <td>Surgical Sutures (Nylon)</td>
                                            <td><span class="badge bg-success p-2">250 packs</span></td>
                                            <td><span class="badge bg-success p-2">30 days</span></td>
                                            <td><canvas id="suturesUsageChart" width="100" height="30"></canvas></td>
                                            <td><button class="btn btn-sm btn-outline-secondary">Details</button></td>
                                        </tr>
                                        <tr>
                                            <td>Adrenaline (Epinephrine)</td>
                                            <td><span class="badge bg-danger p-2">50 amps</span></td>
                                            <td><span class="badge bg-danger p-2">3 days</span></td>
                                            <td><canvas id="adrenalineUsageChart" width="100" height="30"></canvas></td>
                                            <td><button class="btn btn-sm btn-outline-primary">Order Now</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="text-end mt-3"><a href="#" class="btn btn-sm btn-outline-secondary">View All Inventory</a></p>
                        </div>
                    </div>
                    <h2 class="mt-5 mb-3">Recent System Activity</h2>
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-plus-square text-success me-3 fs-5"></i>
                                        <div>
                                            <div class="fw-bold">New item added:</div> Sterilization Kit
                                        </div>
                                    </div>
                                    <span class="badge bg-secondary text-muted">5 mins ago</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-arrow-alt-circle-up text-primary me-3 fs-5"></i>
                                        <div>
                                            <div class="fw-bold">Quantity updated:</div> Paracetamol (from 1000 to 1200)
                                        </div>
                                    </div>
                                    <span class="badge bg-secondary text-muted">1 hour ago</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-sign-in-alt text-info me-3 fs-5"></i>
                                        <div>
                                            <div class="fw-bold">User Login:</div> Pharmacist_01
                                        </div>
                                    </div>
                                    <span class="badge bg-secondary text-muted">2 hours ago</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-tools text-info me-3 fs-5"></i>
                                        <div>
                                            <div class="fw-bold">Repair stage updated:</div> X-Ray machine now "In Progress"
                                        </div>
                                    </div>
                                    <span class="badge bg-secondary text-muted">Yesterday</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-gift text-success me-3 fs-5"></i>
                                        <div>
                                            <div class="fw-bold">New Donation Received:</div> 10 Blood Pressure Monitors
                                        </div>
                                    </div>
                                    <span class="badge bg-secondary text-muted">May 25, 2025</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="inventory-content" class="content-section" style="display:none;">
                    <h1 class="mt-4">Inventory Operations</h1>
                    <p class="lead">Add, update, and manage all hospital inventory items.</p>
                    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addItemModal">
                        <i class="fas fa-plus-circle me-2"></i>Add New Item
                    </button>
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white py-3">
                            <h5 class="mb-0">All Inventory Items</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>Barcode</th>
                                            <th>Item Name</th>
                                            <th>Category</th>
                                            <th>Type</th>
                                            <th>Quantity</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="inventory-table-body">
                                        <tr>
                                            <td>BARC001</td>
                                            <td>Sterile Gauze</td>
                                            <td>Surgical</td>
                                            <td>Dressings</td>
                                            <td>1200</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-info me-2"><i class="fas fa-edit"></i> Update Qty</button>
                                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i> Delete</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="addItemModalLabel">Add New Inventory Item</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="add-item-form">
                                        <div class="mb-3">
                                            <label for="itemName" class="form-label">Item Name</label>
                                            <input type="text" class="form-control" id="itemName" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="itemQuantity" class="form-label">Quantity</label>
                                            <input type="number" class="form-control" id="itemQuantity" min="1" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="itemCategory" class="form-label">Category</label>
                                            <select class="form-select" id="itemCategory" required>
                                                <option value="">Select Category</option>
                                                <option value="general">General</option>
                                                <option value="surgical">Surgical</option>
                                            </select>
                                        </div>
                                        <div class="mb-3" id="itemTypeGroup" style="display:none;">
                                            <label for="itemType" class="form-label">Item Type</label>
                                            <select class="form-select" id="itemType" required>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add Item</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="procurement-content" class="content-section" style="display:none;">
                    <h1 class="mt-4">Procurement Hub</h1>
                    <p class="lead">Manage automated ordering and vendor relationships.</p>
                </div>
                <div id="repairs-content" class="content-section" style="display:none;">
                    <h1 class="mt-4">Maintenance & Repairs</h1>
                    <p class="lead">Track equipment repair stages and analyze common issues.</p>
                </div>
                <div id="users-content" class="content-section" style="display:none;">
                    <h1 class="mt-4">User & System Admin</h1>
                    <p class="lead">Create and manage user accounts, roles, and monitor system activity.</p>
                </div>
                <div id="quality-content" class="content-section" style="display:none;">
                    <h1 class="mt-4">Quality & Donations</h1>
                    <p class="lead">Handle drug quality claims and manage hospital donations.</p>
                </div>
                <div id="reports-content" class="content-section" style="display:none;">
                    <h1 class="mt-4">Reporting Suite</h1>
                    <p class="lead">Generate, customize, and download various reports and documentation.</p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script.js"></script>


      </main>
      
      <footer class="app-footer">
      
      </footer>
   
    </div>
   
  </body>
   




  
</html>
