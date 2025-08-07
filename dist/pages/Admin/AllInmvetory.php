<?php
  
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
    <title>HIMS</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128+Text&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 
    <link href="adminstyle.css" rel="stylesheet">
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
     <?php
       include('Slide_bar.php');

     ?>

     
        <div class="main-content">
            <!-- Topbar -->
           <?php
             include('Topbar.php');

           ?>
      
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
                    window.location.href = "inventory_add_requests.php";
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
                        item_approvals.*,
                        vendors.*
                    
                    
                    FROM 
                        inventory_item
                    JOIN 
                        inventory_category ON inventory_item.category_id = inventory_category.category_id
                    JOIN 
                        inventory_type ON inventory_item.type_id = inventory_type.type_id
                    JOIN 
                        inventory_subtype ON inventory_item.subtype_id = inventory_subtype.subtype_id
                    JOIN 
                        vendors ON inventory_item.vendor_id = vendors.vendor_id  
                    LEFT JOIN
                        item_approvals ON inventory_item.related_item_id=item_approvals.approval_id

                    WHERE
                    inventory_item.status=1    

                    ORDER BY 
                        inventory_item.created_at DESC;
                    ";

                    $result = mysqli_query($conn, $query);
                    ?>
                   <?php
                    // Fetch categories, types, and subtypes for filters
                    $categories = mysqli_query($conn, "SELECT * FROM inventory_category");
                    $types = mysqli_query($conn, "SELECT * FROM inventory_type");
                    $subtypes = mysqli_query($conn, "SELECT * FROM inventory_subtype");
                    ?>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select id="filterCategory" class="form-control">
                                <option value="">All Categories</option>
                                <?php while ($cat = mysqli_fetch_assoc($categories)) { ?>
                                    <option value="<?= htmlspecialchars($cat['category_name']) ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="filterType" class="form-control">
                                <option value="">All Types</option>
                                <?php while ($type = mysqli_fetch_assoc($types)) { ?>
                                    <option value="<?= htmlspecialchars($type['type_name']) ?>"><?= htmlspecialchars($type['type_name']) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="filterSubtype" class="form-control">
                                <option value="">All Subtypes</option>
                                <?php while ($sub = mysqli_fetch_assoc($subtypes)) { ?>
                                    <option value="<?= htmlspecialchars($sub['subtype_name']) ?>"><?= htmlspecialchars($sub['subtype_name']) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="filterStatus" class="form-control">
                                <option value="">All Status</option>
                                <option value="Approved">Approved</option>
                                <option value="Pending">Pending</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search by Name, Description, Serial No...">
                        </div>
                    </div>

                    <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Serial No.or BN Number</th>
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
                        <tr>bn_number
                            <td><?= htmlspecialchars($row['item_name']) ?></td>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td><?= htmlspecialchars($row['serial_number']) ?>
                            <b><?= htmlspecialchars($row['bn_number']) ?></b></td>
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
                                <form action="process_approval.php" method="POST">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="detailsModalLabel<?= $row['item_id'] ?>">
                                                <i class="bi bi-info-circle-fill"></i> Item Details - <?= htmlspecialchars($row['item_name']) ?>
                                            </h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span>&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="border rounded p-3 bg-light">
                                                        <strong>Description:</strong><br><?= htmlspecialchars($row['description']) ?><br><br>
                                                        <strong>Serial Number:</strong><br><?= htmlspecialchars($row['serial_number']) ?><br><br>
                                                        <strong>Batch No:</strong><br><?= htmlspecialchars($row['bn_number']) ?><br><br>

                                                        <?php if ($row['vendor_id'] != 0): ?>
                                                            <strong>Vendor Name:</strong><br><?= htmlspecialchars($row['vendor_name']) ?><br><br>
                                                            <strong>Warranty:</strong><br><?= htmlspecialchars($row['warranty_from']) ?> to <?= htmlspecialchars($row['warranty_to']) ?><br><br>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <div class="border rounded p-3 bg-light">
                                                        <strong>Manufacture Date:</strong><br><?= htmlspecialchars($row['manufacture_date']) ?><br><br>
                                                        <strong>Expiry Date:</strong><br><?= htmlspecialchars($row['expiry_date']) ?><br><br>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 mb-3">
                                                    <div class="border rounded p-3 bg-light">
                                                        <strong>Quntity Avaliable</strong><br><?= htmlspecialchars($row['quantity']) ?><br><br>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                   

                                                   


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

                                                        document.addEventListener('DOMContentLoaded', function() {
                                                            validateQty<?= $row['item_id'] ?>();
                                                        });
                                                    </script>
                                                </div>

                                               
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                           
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


          // table filtering option   
          $(document).ready(function() {
              function filterTable() {
                  var category = $('#filterCategory').val().toLowerCase();
                  var type = $('#filterType').val().toLowerCase();
                  var subtype = $('#filterSubtype').val().toLowerCase();
                  var status = $('#filterStatus').val().toLowerCase();
                  var search = $('#searchInput').val().toLowerCase();

                  $('table tbody tr').each(function() {
                      var row = $(this);
                      var name = row.find('td:nth-child(1)').text().toLowerCase();
                      var desc = row.find('td:nth-child(2)').text().toLowerCase();
                      var serial = row.find('td:nth-child(3)').text().toLowerCase();
                      var qty = row.find('td:nth-child(4)').text().toLowerCase();
                      var cat = row.find('td:nth-child(5)').text().toLowerCase();
                      var typ = row.find('td:nth-child(6)').text().toLowerCase();
                      var subtyp = row.find('td:nth-child(7)').text().toLowerCase();
                      var stat = row.find('td:nth-child(8)').text().toLowerCase();

                      var matchesFilter =
                          (category === "" || cat.includes(category)) &&
                          (type === "" || typ.includes(type)) &&
                          (subtype === "" || subtyp.includes(subtype)) &&
                          (status === "" || stat.includes(status)) &&
                          (name.includes(search) || desc.includes(search) || serial.includes(search));

                      if (matchesFilter) {
                          row.show();
                      } else {
                          row.hide();
                      }
                  });
              }

              $('#filterCategory, #filterType, #filterSubtype, #filterStatus, #searchInput').on('input change', filterTable);
          });




     </script>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

      <footer class="app-footer">
      
      </footer>
   
    </div>
   
  </body>





  
</html>
