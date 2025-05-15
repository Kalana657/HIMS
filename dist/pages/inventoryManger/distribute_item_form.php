<?php
session_start();
?>
<!doctype html>
<html lang="en">



<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>HIMS ADMIN  | Add User</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
        <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery (Required for Bootstrap JS) -->

   


    <!-- Popper.js (Required for dropdowns, tooltips, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Bootstrap 4 JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
     <!-- SweetAlert2 -->
 \
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
    <!--end::Required Plugin(AdminLTE)-->
    <!-- apexcharts -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />
    <!-- jsvectormap -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
      integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
      crossorigin="anonymous"
    />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  





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

       <div class="card shadow-sm border-0 rounded-4 mb-4">
        
            <div class="card-body">

            
            

                <!-- Step 1: Unit Selection -->
                <div class="mb-4">
                    <label for="unitSelect" class="form-label fw-semibold">Select Department / Unit</label>
                    <select id="unitSelect" class="form-select">
                        <option disabled selected>-- Choose Unit --</option>
                        <option>ICU (Critical)</option>
                        <option>Emergency</option>
                        <option>Pediatrics</option>
                        <option>Surgery</option>
                    </select>
                </div>

                <!-- Step 2: Inventory List -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Select Items & Enter Quantity</label>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-bordered">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th style="width: 40px;"><input type="checkbox" id="selectAll"></th>
                                    <th>Item</th>
                                    <th style="width: 120px;">Current Stock</th>
                                    <th style="width: 120px;">Status</th>
                                    <th style="width: 140px;">Distribute Qty</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><input type="checkbox" class="itemCheck"></td>
                                    <td>Paracetamol 500mg</td>
                                    <td class="text-center">1200</td>
                                    <td class="text-center">
                                        <span class="badge bg-success">Available</span>
                                    </td>
                                    <td><input type="number" class="form-control" min="1" placeholder="0"></td>
                                    <td><input type="text" class="form-control" placeholder="Optional..."></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><input type="checkbox" class="itemCheck"></td>
                                    <td>Normal Saline 0.9%</td>
                                    <td class="text-center">50</td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark">Low Stock</span>
                                    </td>
                                    <td><input type="number" class="form-control" min="1" placeholder="0"></td>
                                    <td><input type="text" class="form-control" placeholder="Optional..."></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><input type="checkbox" class="itemCheck"></td>
                                    <td>Surgical Gloves (M)</td>
                                    <td class="text-center">0</td>
                                    <td class="text-center">
                                        <span class="badge bg-danger">Out of Stock</span>
                                    </td>
                                    <td><input type="number" class="form-control" min="1" placeholder="0" disabled></td>
                                    <td><input type="text" class="form-control" placeholder="Optional..."></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Step 3: Summary & Submit -->
                <div class="card border-success shadow-sm p-3 mb-3">
                    <h6 class="fw-bold text-success"><i class="bi bi-clipboard-check me-2"></i> Review and Confirm Distribution</h6>
                    <p class="text-muted">Verify selected items and units before final submission.</p>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Unit Selected:
                            <span class="badge bg-primary">ICU</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Items Selected:
                            <span class="badge bg-success">2 Items</span>
                        </li>
                    </ul>
                    <div class="d-grid">
                        <button class="btn btn-success">
                            <i class="bi bi-check2-circle me-2"></i> Confirm & Distribute
                        </button>
                    </div>
                </div>

            </div>
    </div>

     


      </main>
    

      <footer class="app-footer">
      
      </footer>
   
    </div>
   
  </body>
  <!--end::Body-->




  
</html>