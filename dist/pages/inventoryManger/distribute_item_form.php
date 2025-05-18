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
    <title>HIMS Inventory Manger| Distribute Form</title>
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

            <form action="submit_distribution.php" method="POST" id="distributionForm">
                  <div id="distributionGroups">
                       






                      <!-- Distribution Group Template -->
                      <div class="distribution-group border rounded p-3 mb-3">
                          <div class="mb-3">
                              <label class="form-label fw-semibold">Select Department / Unit</label>
                              <select name="distribution[0][unit_id]" class="form-select unit-select" required>
                                  <option disabled selected>-- Choose Unit --</option>
                                  <?php
                                  include('db_connect.php');
                                  $unitsQuery = "SELECT unit_id, unit_name FROM units ORDER BY unit_name ASC";
                                  $unitsResult = mysqli_query($conn, $unitsQuery);
                                  if ($unitsResult && mysqli_num_rows($unitsResult) > 0) {
                                      while ($row = mysqli_fetch_assoc($unitsResult)) {
                                          echo '<option value="' . $row['unit_id'] . '">' . htmlspecialchars($row['unit_name']) . '</option>';
                                      }
                                  } else {
                                      echo '<option disabled>No units available</option>';
                                  }
                                  ?>
                              </select>
                          </div>

                          <!-- Items Table -->
                          <label class="form-label fw-semibold">Select Items & Enter Quantity</label>
                          <div class="table-responsive">
                              <table class="table table-hover table-bordered align-middle">
                                  <thead class="table-primary text-center">
                                      <tr>
                                          <th><input type="checkbox" class="selectAll"></th>
                                          <th>Item</th>
                                          <th>Current Stock</th>
                                          <th>Status</th>
                                          <th>Distribute Qty</th>
                                          <th>Remarks</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php
                                      $query = "SELECT 
                                                  inventory_item.item_id, 
                                                  inventory_item.item_name, 
                                                  inventory_item.quantity, 
                                                  item_approvals.approved_quantity
                                                FROM inventory_item
                                                JOIN item_approvals ON inventory_item.item_id = item_approvals.item_idat
                                                WHERE inventory_item.status = 1
                                                ORDER BY inventory_item.item_name ASC";
                                      $result = mysqli_query($conn, $query);

                                      if ($result && mysqli_num_rows($result) > 0) {
                                          while ($row = mysqli_fetch_assoc($result)) {
                                              $itemId = $row['item_id'];
                                              $itemName = htmlspecialchars($row['item_name']);
                                              $quantity = htmlspecialchars($row['quantity']);
                                              $approved_quantity = htmlspecialchars($row['approved_quantity']);

                                              $low_stock_level = $approved_quantity * 0.10;
                                              $refill_stock_level = $approved_quantity * 0.30;

                                              if ($quantity > $refill_stock_level) {
                                                  $badgeClass = 'bg-success';
                                                  $statusText = 'Available';
                                                  $inputDisabled = '';
                                              } elseif ($quantity > $low_stock_level) {
                                                  $badgeClass = 'bg-warning text-dark';
                                                  $statusText = 'Refill Recommended';
                                                  $inputDisabled = '';
                                              } elseif ($quantity > 0) {
                                                  $badgeClass = 'bg-warning text-dark';
                                                  $statusText = 'Low Stock';
                                                  $inputDisabled = '';
                                              } else {
                                                  $badgeClass = 'bg-danger';
                                                  $statusText = 'Out of Stock';
                                                  $inputDisabled = 'disabled';
                                              }

                                              echo "<tr>
                                                  <td class='text-center'><input type='checkbox' name='distribution[0][items][$itemId][selected]' value='1' class='itemCheck'></td>
                                                  <td>$itemName</td>
                                                  <td class='text-center'>$quantity</td>
                                                  <td class='text-center'><span class='badge $badgeClass'>$statusText</span></td>
                                                  <td><input type='number' name='distribution[0][items][$itemId][qty]' class='form-control' min='1' placeholder='0' $inputDisabled></td>
                                                  <td><input type='text' name='distribution[0][items][$itemId][remarks]' class='form-control' placeholder='Optional...'></td>
                                              </tr>";
                                          }
                                      } else {
                                          echo '<tr><td colspan="6" class="text-center text-muted">No items found in inventory.</td></tr>';
                                      }
                                      ?>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                  </div>

                  <!-- Button to Add Another Unit Distribution -->
                  <div class="text-end mb-4">
                      <button type="button" class="btn btn-outline-primary" id="addUnitBtn"><i class="bi bi-plus-circle"></i> Add Another Unit</button>
                  </div>

                  <!-- Submit Button -->
                  <div class="d-grid">
                      <button type="submit" class="btn btn-success"><i class="bi bi-check2-circle me-2"></i> Confirm & Distribute</button>
                  </div>
              </form>

            

                
                 
          </div>
       </div>

     


      </main>
    
       <script>
        let distributionIndex = 1;

        $('#addUnitBtn').click(function () {
            let group = $('.distribution-group').first().clone();

            group.find('select, input').each(function () {
                let name = $(this).attr('name');
                if (name) {
                    let newName = name.replace(/\[0\]/, `[${distributionIndex}]`);
                    $(this).attr('name', newName);
                }
                $(this).val('');
            });

            $('#distributionGroups').append(group);
            distributionIndex++;
        });
      </script>

      <footer class="app-footer">
      
      </footer>
   
    </div>
   
  </body>
  <!--end::Body-->




  
</html>