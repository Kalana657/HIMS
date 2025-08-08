<?php
session_start();
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HHIMS - Purchase Order Table</title>
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

 

 <!DOCTYPE html>
<html>
<head>
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">


  <div class="container-fluid">
        <div class="row">
         
                    <?php include('Slidebari.php'); ?>

                
                        <div class="col-lg-10 col-md-9 main-content">
                        
                            <?php include('Header.php'); ?>

<?php    
$query = "SELECT * FROM purchase_orders ORDER BY created_at DESC";
$documents = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Purchase Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h3 class="mb-4">Purchase Orders List</h3>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>PO ID</th>
                <th>Total Cost</th>
                <th>Created</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; while($doc = mysqli_fetch_assoc($documents)): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td>PO#<?= $doc['po_id'] ?></td>
                <td>Rs.<?= number_format($doc['total_cost'], 2) ?></td>
                <td><?= htmlspecialchars($doc['created_at']) ?></td>
                <td>
                    <a href="view_po.php?id=<?= $doc['po_id'] ?>" class="btn btn-sm btn-primary">View PO</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>



    </div>
   </div>
 </div>      
</body>
</html>
