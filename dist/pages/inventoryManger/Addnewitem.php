<?php
session_start();
?> 
<!doctype html>
<html lang="en">



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HHIMS - Add Items</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128+Text&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>



  <div class="container-fluid">
        <div class="row">
         
           <?php include('Slidebari.php'); ?>

       
            <div class="col-lg-10 col-md-9 main-content">
            
                   <?php include('Header.php'); ?>

      
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
                    window.location.href = "Addnewitem.php";
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
            <!-- Begin Updated Form -->
              <form action="add_item.php" method="POST">
                  <!-- Item Name -->
                  <div class="form-group">
                      <label for="item_name">Item Name</label>
                      <input type="text" id="item_name" name="item_name" class="form-control" required>
                  </div>

                  <!-- Description -->
                  <div class="form-group">
                      <label for="description">Description</label>
                      <textarea id="description" name="description" class="form-control"></textarea>
                  </div>

                  <!-- SN Number (always visible) -->
                  <div class="form-group">
                      <label for="serial_number">SN Number</label>
                      <input type="text" id="serial_number" name="serial_number" class="form-control" required>
                  </div>

                  <!-- Quantity -->
                  <div class="form-group">
                      <label for="quantity">Quantity</label>
                      <input type="number" id="quantity" name="quantity" class="form-control" required>
                  </div>

                  <!-- Category Dropdown -->
                  <div class="form-group">
                      <label>Item Category</label>
                      <select id="category" class="form-control" name="category" required>
                          <option value="">-- Select Category --</option>
                          <?php
                          include('db_connect.php');
                          $cat_query = "SELECT category_id, category_name FROM inventory_category";
                          $cat_result = mysqli_query($conn, $cat_query);
                          while ($row = mysqli_fetch_assoc($cat_result)) {
                              echo '<option value="' . $row['category_id'] . '">' . htmlspecialchars($row['category_name']) . '</option>';
                          }
                          ?>
                      </select>
                  </div>

                  <!-- Type Dropdown -->
                  <div class="form-group">
                      <label>Item Type</label>
                      <select id="type" name="type_id" class="form-control" required>
                          <option value="">-- Select Type --</option>
                      </select>
                  </div>

                  <!-- Subtype Dropdown -->
                  <div class="form-group">
                      <label>Sub Type</label>
                      <select id="subtype" name="subtype_id" class="form-control" required>
                          <option value="">-- Select Subtype --</option>
                      </select>
                  </div>

                  <!-- Item Suggestions -->
                  <div id="item-suggestions" class="border p-3 mb-3" style="max-height: 200px; overflow-y: auto;">
                      <!-- Suggestions will load here via AJAX -->
                  </div>

                  <!-- Drug Fields (only for category_id == 2) -->
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

                  <!-- Vendor Field (ALWAYS visible now) -->
                  <div class="form-group">
                      <label for="vendor_id">Vendor Name</label>
                      <select id="vendor_id" name="vendor_id" class="form-control">
                          <option value="">-- Select Vendor --</option>
                          <!-- Loaded via AJAX -->
                      </select>
                  </div>

                  <!-- Warranty Fields (only visible for category_id 1 or 4) -->
                  <div id="warranty-fields" style="display: none;">
                      <div class="form-group">
                          <label for="warranty_from">Warranty From Date</label>
                          <input type="date" id="warranty_from" name="warranty_from" class="form-control">
                      </div>
                      <div class="form-group">
                          <label for="warranty_to">Warranty To Date</label>
                          <input type="date" id="warranty_to" name="warranty_to" class="form-control">
                      </div>
                  </div>

                  <!-- Submit -->
                  <button type="submit" class="btn btn-success mt-3">Request Add Item</button>
              </form>
              <!-- End Updated Form -->

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

    // Show/Hide Warranty Fields only
    if (categoryID == 1 || categoryID == 4) {
        $('#warranty-fields').show();
    } else {
        $('#warranty-fields').hide();
        $('#warranty_from').val('');
        $('#warranty_to').val('');
    }

    // Load Types
    if (categoryID) {
        $.post('get_types.php', { category_id: categoryID }, function(html) {
            $('#type').html(html);
            $('#subtype').html('<option value="">Select Subtype</option>');
        });

        // Load Vendors for all categories
        $.post('get_vendors.php', { category_id: categoryID }, function(html) {
            $('#vendor_id').html(html);
        });
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
