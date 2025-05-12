<?php
session_start();


?>




<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>HIMS ADMIN  | Inventory Add Requests Table</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
        <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery (Required for Bootstrap JS) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <!-- Popper.js (Required for dropdowns, tooltips, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Bootstrap 4 JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
     <!-- SweetAlert2 -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
      
      <?php

        if (isset($_SESSION['status']) && isset($_SESSION['message'])) {
            echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    title: "' . ucfirst($_SESSION['status']) . '!",
                    text: "' . $_SESSION['message'] . '",
                    icon: "' . $_SESSION['status'] . '",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "Addnewuser.php";
                });
            </script>';
            
            // Clear session variables after displaying the message
            unset($_SESSION['status']);
            unset($_SESSION['message']);
        }
?>








       
<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-header">
      <h5 class="mb-0">Inventory Add Requests Table</h5>
    </div>
                        <?php
                    include('db_connect.php');

                   $query = "
                   SELECT 
                        inventory_item.*,
                        inventory_category.*,
                        inventory_type.*,
                        inventory_subtype.*,
                        item_approvals.*
                    
                    
                    FROM 
                        inventory_item
                    JOIN 
                        inventory_category ON inventory_item.category_id = inventory_category.category_id
                    JOIN 
                        inventory_type ON inventory_item.type_id = inventory_type.type_id
                    JOIN 
                        inventory_subtype ON inventory_item.subtype_id = inventory_subtype.subtype_id
                    LEFT JOIN
                        item_approvals ON inventory_item.related_item_id=item_approvals.approval_id

                    ORDER BY 
                        inventory_item.created_at DESC;
                    ";

                    $result = mysqli_query($conn, $query);
                    ?>

                    <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Serial No.</th>
                        <th>Qty</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Subtype</th>
                        <th>Status</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['item_name']) ?></td>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td><?= htmlspecialchars($row['serial_number']) ?></td>
                            <td><?= htmlspecialchars($row['quantity']) ?></td>
                            <td><?= htmlspecialchars($row['category_name']) ?></td>
                            <td><?= htmlspecialchars($row['type_name']) ?></td>
                            <td><?= htmlspecialchars($row['subtype_name']) ?></td>

                            <td>
                            <?php
                                if ($row['status'] == 1) {
                                echo '<span class="badge badge-success">Approved</span>';
                                } elseif ($row['status'] == 0) {
                                echo '<span class="badge badge-warning">Pending</span>';
                                } else {
                                echo '<span class="badge badge-danger">Rejected</span>';
                                }
                            ?>
                            </td>
                            <td>
                               
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailsModal<?= $row['item_id'] ?>" title="View More">
                                <i class="bi bi-eye-fill"></i>
                                </button>

                              


                            </td>
                            
                        </tr>

                      
                      <!-- View More Modal -->
                    <div class="modal fade" id="detailsModal<?= $row['item_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel<?= $row['item_id'] ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <form action="process_approval.php" method="POST"> <!-- You can adjust this file -->
                        <input type="hidden" name="item_id" value="<?= $row['item_id'] ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="detailsModalLabel<?= $row['item_id'] ?>">Item Details - <?= htmlspecialchars($row['item_name']) ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                            </div>
                            
                            <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                <strong>Description:</strong><br><?= htmlspecialchars($row['description']) ?><br><br>
                                <strong>Serial Number:</strong><br><?= htmlspecialchars($row['serial_number']) ?><br><br>
                                <strong>Batch No:</strong><br><?= htmlspecialchars($row['bn_number']) ?><br><br>
                                <strong>Vendor ID:</strong><br><?= htmlspecialchars($row['vendor_id']) ?><br><br>
                                <strong>Warranty:</strong><br><?= htmlspecialchars($row['warranty_from']) ?> to <?= htmlspecialchars($row['warranty_to']) ?><br><br>
                                </div>
                                <div class="col-md-6">
                                <strong>Manufacture Date:</strong><br><?= htmlspecialchars($row['manufacture_date']) ?><br><br>
                                <strong>Expiry Date:</strong><br><?= htmlspecialchars($row['expiry_date']) ?><br><br>
                                <strong>Created At:</strong><br><?= htmlspecialchars($row['created_at']) ?><br><br>
                                <strong>Updated At:</strong><br><?= htmlspecialchars($row['updated_at']) ?><br><br>
                                
                                <?php
                                    $approvedQty = $row['approved_quantity'];
                                    $requestedQty = $row['quantity'];

                                    $qtyClass = '';
                                    $qtyNote = '';

                                    if ($approvedQty > $requestedQty) {
                                        $qtyClass = 'bg-warning text-dark';
                                        $qtyNote = 'Less than requested';
                                    } elseif ($approvedQty < $requestedQty) {
                                        $qtyClass = 'bg-danger text-white';
                                        $qtyNote = 'More than requested';
                                    } else {
                                        $qtyClass = 'bg-success text-white';
                                        $qtyNote = 'Exact as requested';
                                    }
                                    ?>

                                    <div class="form-group">
                                        <label><strong>Approved Quantity</strong></label>
                                        <input type="text" class="form-control <?= $qtyClass ?>" value="<?= htmlspecialchars($approvedQty) ?>" readonly>
                                        <small class="form-text"><?= $qtyNote ?></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="quantity<?= $row['item_id'] ?>"><strong>Edit Requested Quantity</strong></label>
                                        <input type="number" 
                                            name="quantity" 
                                            id="quantity<?= $row['item_id'] ?>" 
                                            value="<?= htmlspecialchars($requestedQty) ?>" 
                                            class="form-control"
                                            max="<?= $approvedQty ?>" 
                                            required 
                                            oninput="validateQty<?= $row['item_id'] ?>()">
                                        <small id="errorMsg<?= $row['item_id'] ?>" class="text-danger" style="display:none;">Requested quantity cannot exceed approved quantity!</small>
                                    </div>

                                    <script>
                                    function validateQty<?= $row['item_id'] ?>() {
                                        var input = document.getElementById('quantity<?= $row['item_id'] ?>');
                                        var errorMsg = document.getElementById('errorMsg<?= $row['item_id'] ?>');
                                        var approveBtn = document.querySelector('#detailsModal<?= $row['item_id'] ?> button[name="approve"]');
                                        var approvedQty = <?= $approvedQty ?>;
                                        
                                        if (parseInt(input.value) > approvedQty) {
                                            errorMsg.style.display = 'block';
                                            input.classList.add('is-invalid');
                                            approveBtn.disabled = true;
                                        } else {
                                            errorMsg.style.display = 'none';
                                            input.classList.remove('is-invalid');
                                            approveBtn.disabled = false;
                                        }
                                    }

                                    // Initialize check on modal open (optional safety check)
                                    document.addEventListener('DOMContentLoaded', function() {
                                        validateQty<?= $row['item_id'] ?>();
                                    });
                                    </script>




                                
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="comment<?= $row['item_id'] ?>"><strong>Admin Comment</strong></label>
                                <textarea name="comment" id="comment<?= $row['item_id'] ?>" class="form-control" rows="3" placeholder="Enter any remarks..."></textarea>
                            </div>
                            </div>

                            <div class="modal-footer">
                            <button type="submit" name="reject" class="btn btn-danger">
                                <i class="bi bi-x-circle-fill"></i> Reject
                            </button>
                            <button type="submit" name="approve" class="btn btn-success">
                                <i class="bi bi-check-circle-fill"></i> Approve
                            </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        </form>
                    </div>
                    </div>

                        <?php } ?>
                    </tbody>
                    </table>





  </div>  
</div>

      </main>
      <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
     </script>

      <footer class="app-footer">
      
      </footer>
   
    </div>
   
  </body>
  <!--end::Body-->




  
</html>
