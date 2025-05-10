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
            <h5 class="mb-0">Add New Item</h5>
        </div>
        <div class="card-body">
            <form action="add_item.php" method="POST">
                <!-- Item Name -->
                <div class="form-group">
                    <label for="item_name">Item Name</label>
                    <input type="text" id="item_name" name="item_name" class="form-control" required>
                </div>

                <!-- Item Description -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control"></textarea>
                </div>

                <!-- Item Serial Number -->
                <div class="form-group">
                    <label for="serial_number">SN Number</label>
                    <input type="text" id="serial_number" name="serial_number" class="form-control" required>
                </div>

                <!-- Item Quantity -->
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" required>
                </div>
               

                <!-- Category Dropdown -->
                <div class="form-group">
                    <label>Item Category</label>
                    <select id="category" class="form-control" name="category">
                        <option value="">-- Select Category --</option>
                        
                
                                <?php
                               
                                include('db_connect.php'); 

                                $query = "SELECT category_id, category_name FROM inventory_category";
                                $result = mysqli_query($conn, $query);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $row['category_id'] . '">' . htmlspecialchars($row['category_name']) . '</option>';
                                    }
                                } else {
                                    echo '<option disabled>No Category found</option>';
                                }
                                ?>
         
                    </select>
                </div>

                <!-- Type Dropdown -->
                <div class="form-group">
                    <label>Item Type</label>
                    <select id="type" name="type_id" class="form-control" required>
                        <option value="">-- Select Type --</option>
                        <!-- Types will be loaded based on selected category -->
                    </select>
                </div>

                <!-- Subtype Dropdown -->
                <div class="form-group">
                    <label>Sub Type</label>
                    <select id="subtype" name="subtype_id" class="form-control" required>
                        <option value="">-- Select Subtype --</option>
                        <!-- Subtypes will be loaded based on selected type -->
                    </select>
                

                </div>
             
                <div id="item-suggestions" class="border p-3 mb-3" style="max-height: 200px; overflow-y: auto;">
                  <?php
                  // Assuming $result is already fetched from the database
                  while ($row = mysqli_fetch_assoc($result)) {
                      echo '<div class="mb-2">
                              <input type="checkbox" name="item_ids[]" value="' . htmlspecialchars($row['item_id']) . '">
                              <strong>' . htmlspecialchars($row['item_name']) . '</strong><br>
                              Quantity: <strong>' . htmlspecialchars($row['quantity']) . '</strong><br>
                            </div><hr>';
                  }
                  ?>
              </div>

             




   
                 <!-- Drug Fields: Only visible if category_id == 2 -->
                    <div id="drug-fields" style="display: none;">
                        <div class="form-group">
                            <label for="bn_number">BN Number</label>
                         
                            <input type="text" id="bn_number" name="bn_number" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="manufacture_date">Manufacture Date</label>
                            <input type="date" id="manufacture_date" name="manufacture_date" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="expiry_date">Expiry Date</label>
                            <input type="date" id="expiry_date" name="expiry_date" class="form-control">
                        </div>
                    </div>


                <!-- Warranty & Vendor Fields: Only visible if category_id == 1 or 4 -->
                <div id="warranty-fields" style="display: none;">
                    <div class="form-group">
                        <label for="warranty_from">Warranty From Date</label>
                        <input type="date" id="warranty_from" name="warranty_from" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="warranty_to">Warranty To Date</label>
                        <input type="date" id="warranty_to" name="warranty_to" class="form-control">
                    </div>

                    <div class="form-group">
                    <label for="vendor_id">Vendor Name</label>
                    <select id="vendor_id" name="vendor_id" class="form-control">
                      <option value="">-- Select Vendor --</option>
                      <!-- Options loaded via AJAX -->
                    </select>
                  </div>
                </div>






                <!-- Submit Button -->
                <button type="submit" class="btn btn-success mt-3">Request Add Item</button>
            </form>
        </div>
    </div>
</div>
      


<script>

// multi drop down list
$(document).ready(function() {
  $('#category').on('change', function() {
    let categoryID = $(this).val();
    if (categoryID) {
      $.ajax({
        type: 'POST',
        url: 'get_types.php',
        data: { category_id: categoryID },
        success: function(html) {
          $('#type').html(html);
          $('#subtype').html('<option value="">Select Subtype</option>');
        }
      });
    } else {
      $('#type').html('<option value="">Select Type</option>');
      $('#subtype').html('<option value="">Select Subtype</option>');
    }
  });

  $('#type').on('change', function() {
    let typeID = $(this).val();
    if (typeID) {
      $.ajax({
        type: 'POST',
        url: 'get_subtypes.php',
        data: { type_id: typeID },
        success: function(html) {
          $('#subtype').html(html);
        }
      });
    } else {
      $('#subtype').html('<option value="">Select Subtype</option>');
    }
  });
});

// show the BN number and other columes
$('#category').on('change', function() {
    let categoryID = $(this).val();

  
    if (categoryID == 2) {
        $('#drug-fields').show();
    } else {
        $('#drug-fields').hide();
        $('#bn_number').val('');
        $('#manufacture_date').val('');
        $('#expiry_date').val('');
    }
    if (categoryID) {
        $.ajax({
            type: 'POST',
            url: 'get_types.php',
            data: { category_id: categoryID },
            success: function(html) {
                $('#type').html(html);
                $('#subtype').html('<option value="">Select Subtype</option>');
            }
        });
    } else {
        $('#type').html('<option value="">Select Type</option>');
        $('#subtype').html('<option value="">Select Subtype</option>');
    }
});


$('#category').on('change', function() {
    let categoryID = $(this).val();

    // Show/Hide Drug Fields
    if (categoryID == 2) {
        $('#drug-fields').show();
    } else {
        $('#drug-fields').hide();
        $('#bn_number').val('');
        $('#manufacture_date').val('');
        $('#expiry_date').val('');
    }

    // Show/Hide Warranty & Vendor Fields
    if (categoryID == 1 || categoryID == 4) {
        $('#warranty-fields').show();
    } else {
        $('#warranty-fields').hide();
        $('#warranty_from').val('');
        $('#warranty_to').val('');
        $('#vendor_id').val('');
    }

    // Load Types
    if (categoryID) {
        $.ajax({
            type: 'POST',
            url: 'get_types.php',
            data: { category_id: categoryID },
            success: function(html) {
                $('#type').html(html);
                $('#subtype').html('<option value="">Select Subtype</option>');
            }
        });

        // Load Vendors
        $.ajax({
            type: 'POST',
            url: 'get_vendors.php',
            data: { category_id: categoryID },
            success: function(html) {
                $('#vendor_id').html(html);
            }
        });
    } else {
        $('#type').html('<option value="">Select Type</option>');
        $('#subtype').html('<option value="">Select Subtype</option>');
    }
});

// Suggtion field

$('#subtype').on('change', function () {
    const categoryID = $('#category').val();
    const typeID = $('#type').val();
    const subtypeID = $(this).val();

    if (categoryID && typeID && subtypeID) {
        $.ajax({
            type: 'POST',
            url: 'get_related_items.php',
            data: {
                category_id: categoryID,
                type_id: typeID,
                subtype_id: subtypeID
            },
            success: function (response) {
                $('#item-suggestions').html(response);
                $('#suggestion-fields').show();
            },
            error: function () {
                $('#item-suggestions').html('<p class="text-danger">Error fetching data.</p>');
                $('#suggestion-fields').show();
            }
        });
    } else {
        $('#item-suggestions').html('<p class="text-muted">Select a subtype to view related items</p>');
        $('#suggestion-fields').hide();
    }
});


</script>







      </main>
    

      <footer class="app-footer">
      
      </footer>
   
    </div>
   
  </body>
  <!--end::Body-->




  
</html>
