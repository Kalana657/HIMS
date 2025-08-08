<?php
session_start();
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HHIMS - Report Table</title>
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

   
   
   
<!DOCTYPE html>
<html>
<head>
    <title>Drug Donation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">


  <div class="container-fluid">
        <div class="row">
         
                    <?php include('Slidebari.php'); ?>

                
                        <div class="col-lg-10 col-md-9 main-content">
                        
                            <?php include('Header.php'); ?>








<?php
include 'db_connect.php';

$type_filter = isset($_GET['type']) ? mysqli_real_escape_string($conn, $_GET['type']) : '';
$query = "SELECT * FROM documents";
if ($type_filter) {
    $query .= " WHERE document_type = '$type_filter'";
}
$query .= " ORDER BY created_at DESC";
$documents = mysqli_query($conn, $query);

?>



    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Document Name</th>
                <th>Type</th>
                <th>View Details</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; while($doc = mysqli_fetch_assoc($documents)): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($doc['document_name']) ?></td>
                <td><?= htmlspecialchars($doc['document_type']) ?></td>
                <td>
                    <a href="view_document.php?table=<?= $doc['related_table'] ?>&id=<?= $doc['related_record_id'] ?>" class="btn btn-sm btn-primary">
                        View
                    </a>
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
