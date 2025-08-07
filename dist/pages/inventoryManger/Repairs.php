<?php
session_start();
include('db_connect.php');
?> 




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HHIMS - Add Inventory Table</title>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

 

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

                <?php
                if (isset($_SESSION['status']) && isset($_SESSION['message'])) {
                    echo "
                    <script>
                        Swal.fire({
                            icon: '" . htmlspecialchars($_SESSION['status']) . "',
                            title: '" . ucfirst(htmlspecialchars($_SESSION['status'])) . "!',
                            text: '" . htmlspecialchars($_SESSION['message']) . "',
                            confirmButtonText: 'OK'
                        });
                    </script>";
                    unset($_SESSION['status']);
                    unset($_SESSION['message']);
                }

                ?>
                <?php   
                
                $query = "SELECT 
                        repair_requests.*, 
                        inventory_item.*, 
                        repair_stages.*,
                        units.unit_name 
                    FROM 
                        repair_requests
                    LEFT JOIN 
                        inventory_item ON repair_requests.item_id = inventory_item.item_id
                    LEFT JOIN 
                        repair_stages ON repair_requests.status = repair_stages.stage_id
                    LEFT JOIN 
                         units ON repair_requests.unit_id = units.unit_id    
                    ORDER BY 
                        repair_requests.created_at DESC";

            $result = mysqli_query($conn, $query);
            ?>

            <h4>Repair Requests History</h4>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Serial No.</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Requested Unit</th>
                        <th>Requested At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['item_name']) ?></td>
                            <td><?= htmlspecialchars($row['serial_number']) ?></td>
                            <td><?= htmlspecialchars($row['reason']) ?></td>
                            <td><?= htmlspecialchars(ucfirst($row['stage_name'])) ?></td>
                            <td><?= htmlspecialchars(ucfirst($row['unit_name'])) ?></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal<?= $row['request_id'] ?>">
                                    <i class="bi bi-eye"></i> View
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php
mysqli_data_seek($result, 0); // reset pointer to loop again
while ($row = mysqli_fetch_assoc($result)):
?>
<div class="modal fade" id="viewModal<?= $row['request_id'] ?>" tabindex="-1" aria-labelledby="viewModalLabel<?= $row['request_id'] ?>" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewModalLabel<?= $row['request_id'] ?>">Repair Request Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Item Name:</strong> <?= htmlspecialchars($row['item_name']) ?></p>
        <p><strong>Serial No.:</strong> <?= htmlspecialchars($row['serial_number']) ?></p>
        <p><strong>Reason:</strong> <?= htmlspecialchars($row['reason']) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($row['stage_name']) ?></p>
        <p><strong>Requested At:</strong> <?= htmlspecialchars($row['created_at']) ?></p>

        <!-- Image section -->
        <?php if (!empty($row['image_path'])): ?>
            <div class="mb-3">
                <strong>Uploaded Image:</strong><br>
            <img src="../Unit_incharge/uploads/repair_images/<?= htmlspecialchars($row['image_path']) ?>" class="img-fluid border rounded" style="max-height:300px;">
            </div>
            <?php else: ?>
            <p><strong>Uploaded Image:</strong> No image available.</p>
            <?php endif; ?>


        <!-- Stage update form -->
        <form action="update_stage.php" method="POST">
            <input type="hidden" name="request_id" value="<?= $row['request_id'] ?>">
            <div class="mb-3">
                <label for="stage" class="form-label">Update Status</label>
                <select name="stage" id="stage" class="form-select" required>
                    <option value="">-- Select Stage --</option>
                    <?php
                    $stageQuery = "SELECT stage_id, stage_name FROM repair_stages WHERE stage_status = 1";
                    $stageResult = mysqli_query($conn, $stageQuery);
                    while ($stage = mysqli_fetch_assoc($stageResult)):
                    ?>
                    <option value="<?= $stage['stage_id'] ?>" <?= $stage['stage_id'] == $row['stage_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($stage['stage_name']) ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3 text-end">
                <button type="submit" class="btn btn-success">Update Stage</button>
            </div>
        </form>

        <!-- Stage History -->
        <div class="mt-4">
            <h6>Stage Update History</h6>
            <ul class="list-group">
                <?php
                $historyQuery = "SELECT repair_stage_logs.*, repair_stages.stage_name
                                FROM repair_stage_logs 
                                JOIN repair_stages ON repair_stage_logs.stage_id = repair_stages.stage_id 
                                WHERE repair_stage_logs.request_id = " . $row['request_id'] . " 
                                ORDER BY repair_stage_logs.updated_at ASC";
                $historyResult = mysqli_query($conn, $historyQuery);
                if (mysqli_num_rows($historyResult) > 0):
                    while ($log = mysqli_fetch_assoc($historyResult)):
                ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($log['stage_name']) ?></strong>
                     — <?= htmlspecialchars($log['updated_at']) ?>
                   
                </li>
                <?php endwhile; else: ?>
                <li class="list-group-item">No stage history available.</li>
                <?php endif; ?>
            </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endwhile; ?>

    </div>
</div>  

  



</body>
</html>