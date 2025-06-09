<?php
session_start();
include('db_connect.php');
?> 




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HIMS - Add Inventory Table</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128+Text&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 

    <!-- JsBarcode CDN for barcode generation -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

    <style>
    @media print {
        body * {
            visibility: hidden;
        }
        .print-barcode-container, 
        .print-barcode-container * {
            visibility: visible;
        }
        .print-barcode-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 20px;
        }
        .no-print {
            display: none !important;
        }
        .barcode-print {
            margin: 20px auto;
        }
    }
    </style>
</head>
<body class="bg-light">


  <div class="container-fluid">
        <div class="row">
         
           <?php include('Slidebari.php'); ?>

       
            <div class="col-lg-10 col-md-9 main-content">
            
                   <?php include('Header.php'); ?>

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

                 

                  <!-- Submit Button -->
                  <div class="d-grid">
                      <button type="submit" class="btn btn-success"><i class="bi bi-check2-circle me-2"></i> Confirm & Distribute</button>
                  </div>
              </form>

            

                
                 
          </div>
       </div>

     


      </main>
    
      

      <footer class="app-footer">
      
      </footer>
   
    </div>
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  </body>
 




  
</html>