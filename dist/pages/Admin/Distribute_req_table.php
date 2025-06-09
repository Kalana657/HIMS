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
                    window.location.href = "Distribute_req_table.php";
                });
            </script>';
            
           
            unset($_SESSION['status']);
            unset($_SESSION['message']);
        }
       ?>
            <?php
           

                    include('db_connect.php');
                    $sql = "SELECT 
                        inventory_item.item_id,
                        inventory_item.item_name,
                        SUM(item_distributions.Approval_distributed_quantity) AS total_approved,
                        SUM(item_distributions.distributed_quantity) AS total_distributed
                    FROM 
                        item_distributions
                    JOIN 
                        inventory_item ON item_distributions.item_id = inventory_item.item_id
                    GROUP BY 
                        inventory_item.item_id";


                    $result = $conn->query($sql);
                    ?>

                    <div class="container mt-4">
                        <h4 class="mb-3">Drug Distribution Summary</h4>
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Drug Name</th>
                                    <th>Total Requested</th>
                                    <th>Total Approved</th>
                                    <th>Total Distributed</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $result->fetch_assoc()): 
                                   
                                    $status = 'Pending';
                                    if ($row['total_distributed'] <= $row['total_approved']) {
                                        $status = 'Completed';
                                    } elseif ($row['total_distributed'] > 0) {
                                        $status = 'Partially Completed';
                                    }
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['item_name']) ?></td>
                                        <td><?= (int)$row['total_distributed'] ?></td>
                                        <td><?= (int)$row['total_approved'] ?></td>
                                        <td><?= (int)$row['total_distributed'] ?></td>
                                        <td>
                                            <?php if ($status === 'Completed'): ?>
                                                <span class="badge badge-success"><?= $status ?></span>
                                            <?php elseif ($status === 'Partially Completed'): ?>
                                                <span class="badge badge-info"><?= $status ?></span>
                                            <?php else: ?>
                                                <span class="badge badge-warning"><?= $status ?></span>
                                            <?php endif; ?>
                                        </td>
                                         <td>
                                          <button class="btn btn-outline-primary btn-sm view-units" 
                                                  data-toggle="modal" 
                                                  data-target="#unitModal" 
                                                  data-itemid="<?= $row['item_id'] ?>" 
                                                  data-itemname="<?= htmlspecialchars($row['item_name']) ?>">
                                            View Units
                                          </button>
                                        </td>





                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                     </div>



                
                <!-- Modal -->
              <div class="modal fade" id="unitModal" tabindex="-1" role="dialog" aria-labelledby="unitModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                      <h5 class="modal-title" id="unitModalLabel">Unit Requests</h5>
                      <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form id="approval-form">
                        <table class="table table-sm table-striped">
                          <thead>
                            <tr>
                              <th>Unit</th>
                              <th>Distributed Qty</th>
                              <th>Approval Qty</th>
                            </tr>
                          </thead>
                          <tbody id="unit-distribution-table">
                         
                          </tbody>
                        </table>
                        <div class="text-right">
                          <button type="submit" class="btn btn-success">Approve</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
  


                                       
                                          




       

    </main>
     <script>
       $(document).ready(function() {
    // View units button click
    $(document).on('click', '.view-units', function() {
        const itemId = $(this).data('itemid');
        const itemName = $(this).data('itemname');
        $('#unitModalLabel').text(`Unit Requests - ${itemName}`);

        $.ajax({
            url: 'get_unit_distribution.php',
            type: 'POST',
            data: { item_id: itemId },
            success: function(response) {
                $('#unit-distribution-table').html(response);
            },
            error: function() {
                $('#unit-distribution-table').html('<tr><td colspan="3">Error loading data</td></tr>');
            }
        });
    });

    // Form submission handler
    $('#approval-form').on('submit', function(e) {
        e.preventDefault();
        
        // Collect all approval data
        const approvals = [];
        let hasErrors = false;
        
        $('#unit-distribution-table tr').each(function() {
            const distributionId = $(this).data('id');
            const approvalQty = $(this).find('.approval-input').val();
            const requestedQty = parseInt($(this).find('.approval-input').attr('max'));
            
            if (approvalQty === '' || isNaN(approvalQty) || approvalQty < 0) {
                Swal.fire('Error', 'Please enter valid approval quantities for all rows.', 'error');
                hasErrors = true;
                return false; // break out of the loop
            }
            
            if (parseInt(approvalQty) > requestedQty) {
                Swal.fire('Error', 'Approval quantity cannot exceed requested quantity.', 'error');
                hasErrors = true;
                return false; // break out of the loop
            }
            
            approvals.push({
                id: distributionId,
                qty: approvalQty
            });
        });
        
        if (hasErrors) return;
        
        // Send all approvals at once
        $.ajax({
            url: 'approve_unit_distribution.php',
            type: 'POST',
            data: { approvals: JSON.stringify(approvals) },
            success: function(res) {
                Swal.fire('Success', 'Approval quantities updated.', 'success')
                    .then(() => {
                        $('#unitModal').modal('hide');
                        // Optional: refresh the page or table
                        location.reload();
                    });
            },
            error: function() {
                Swal.fire('Error', 'An error occurred while saving approvals.', 'error');
            }
        });
    });
});
                
       
      </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

      <footer class="app-footer">
      
      </footer>
   
    </div>
   
  </body>





  
</html>
