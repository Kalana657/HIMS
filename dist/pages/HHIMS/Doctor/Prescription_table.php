<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['username'])) {
    die("Access denied. Please login first.");
}

$doctor = "Dr." . $_SESSION['username'];

// Step 1: Get distinct prescriptions with patient info for this doctor
$sql = "SELECT 
            p.prescription_id,
            p.patient_id,
            pat.fname,
            pat.lname,
            p.date_prescribed,
            p.diagnosis,
            p.notes,
            p.prescribed_by
        FROM prescriptions p
        JOIN patients pat ON p.patient_id = pat.patient_id
        WHERE p.prescribed_by = ?
        GROUP BY p.prescription_id
        ORDER BY p.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $doctor);
$stmt->execute();
$prescriptions_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Prescriptions for <?= htmlspecialchars($doctor) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">




    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HIMS </title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128+Text&display=swap" rel="stylesheet">
</head>
<body>
     <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include('sidebar.php') ?>

            <!-- Main Content -->
            <div class="col-md-10 ms-sm-auto main-content">
                <!-- Header -->
                <?php include('header.php') ?>

</head>

    <h2>Prescriptions for <?= htmlspecialchars($doctor) ?></h2>

    <?php if ($prescriptions_result->num_rows > 0): ?>
        <?php while ($prescription = $prescriptions_result->fetch_assoc()): ?>
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <strong>Prescription ID:</strong> <?= htmlspecialchars($prescription['prescription_id']) ?> |
                    <strong>Patient:</strong> <?= htmlspecialchars($prescription['fname'] . ' ' . $prescription['lname']) ?> |
                    <strong>Date:</strong> <?= htmlspecialchars(date('Y-m-d', strtotime($prescription['date_prescribed']))) ?>
                </div>
                <div class="card-body">
                    <p><strong>Diagnosis:</strong> <?= htmlspecialchars($prescription['diagnosis']) ?></p>
                    <p><strong>Notes:</strong> <?= htmlspecialchars($prescription['notes']) ?></p>
                    <p><strong>Prescribed by:</strong> <?= htmlspecialchars($prescription['prescribed_by']) ?></p>

                    <?php
                    // Step 2: Fetch drugs for this prescription
                    $drug_sql = "SELECT i.item_name, p.drug_qte 
                                 FROM prescriptions p
                                 JOIN inventory_item i ON p.drug_id = i.item_id
                                 WHERE p.prescription_id = ?";
                    $drug_stmt = $conn->prepare($drug_sql);
                    $drug_stmt->bind_param("i", $prescription['prescription_id']);
                    $drug_stmt->execute();
                    $drug_result = $drug_stmt->get_result();
                    ?>

                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr class="table-secondary">
                                <th>Drug Name</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($drug = $drug_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($drug['item_name']) ?></td>
                                    <td><?= htmlspecialchars($drug['drug_qte']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                    <?php $drug_stmt->close(); ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No prescriptions found.</p>
    <?php endif; ?>
    </div>
    </div>
    </div>
</body>
</html>
