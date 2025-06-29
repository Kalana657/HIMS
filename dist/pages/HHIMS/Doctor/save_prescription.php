<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['unitin_id'])) {
    die("Access denied. Please login first.");
}
$unit_id = $_SESSION['unitin_id'];

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid access.");
}

$patient_id = intval($_POST['patient_id'] ?? 0);
if ($patient_id <= 0) {
    die("Invalid patient ID.");
}

$diagnosis = trim($_POST['diagnosis'] ?? '');
$notes = trim($_POST['notes'] ?? '');
$prescribed_by = trim($_POST['prescribed_by'] ?? '');

$drug_ids = $_POST['drug_name'] ?? [];
$frequencies = $_POST['frequency'] ?? [];
$doses = $_POST['dose'] ?? [];
$durations = $_POST['duration'] ?? [];
$routes = $_POST['route'] ?? [];
$instructions = $_POST['instructions'] ?? [];

// Validate required fields
if (empty($diagnosis) || empty($prescribed_by) || empty($drug_ids)) {
    die("Please fill all required fields.");
}

// Prepare insert statement
$insert_sql = "INSERT INTO prescriptions 
        (patient_id, unit_id, drug_id, drug_qte, date_prescribed, diagnosis, notes, prescribed_by, created_at)
        VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, NOW())";

$insert_stmt = $conn->prepare($insert_sql);
if (!$insert_stmt) {
    die("Prepare failed (insert): " . $conn->error);
}

foreach ($drug_ids as $index => $drug_id) {
    $drug_id = intval($drug_id);
    if ($drug_id <= 0) continue;

    $dose = floatval($doses[$index] ?? 0);
    $frequency = $frequencies[$index] ?? '';
    $duration = $durations[$index] ?? '';

    // Frequency mapping
    $freq_map = [
        "Once daily" => 1,
        "Twice daily" => 2,
        "Thrice daily" => 3,
        "Every 6 hours" => 4,
        "As needed" => 1,
        "1" => 1,
        "2" => 2,
        "3" => 3,
        "4" => 4,
    ];
    $freq_num = $freq_map[$frequency] ?? 1;

    preg_match('/\d+/', $duration, $matches);
    $duration_num = isset($matches[0]) ? intval($matches[0]) : 1;

    $total_quantity = $dose * $freq_num * $duration_num;

    // Insert prescription
    $insert_stmt->bind_param(
        "iiiisss",
        $patient_id,
        $unit_id,
        $drug_id,
        $total_quantity,
        $diagnosis,
        $notes,
        $prescribed_by
    );

    if (!$insert_stmt->execute()) {
        die("Insert failed: " . $insert_stmt->error);
    }

    // Recalculate total prescribed for this patient & drug
    $sum_sql = "SELECT SUM(drug_qte) AS total_prescribed 
                FROM prescriptions 
                WHERE patient_id = ? AND unit_id = ? AND drug_id = ?";
    
    $sum_stmt = $conn->prepare($sum_sql);
    $sum_stmt->bind_param("iii", $patient_id, $unit_id, $drug_id);
    $sum_stmt->execute();
    $sum_result = $sum_stmt->get_result();
    $sum_row = $sum_result->fetch_assoc();
    $total_prescribed = $sum_row['total_prescribed'] ?? 0;
    $sum_stmt->close();

    // Get original distributed quantity
    $dist_sql = "SELECT distributed_quantity FROM item_distributions 
                 WHERE unit_id = ? AND item_id = ?";
    $dist_stmt = $conn->prepare($dist_sql);
    $dist_stmt->bind_param("ii", $unit_id, $drug_id);
    $dist_stmt->execute();
    $dist_result = $dist_stmt->get_result();
    $dist_row = $dist_result->fetch_assoc();
    $distributed_qty = $dist_row['distributed_quantity'] ?? 0;
    $dist_stmt->close();

    // Calculate remaining
    $new_remaining = $distributed_qty - $total_prescribed;

    // Prevent negative stock
    if ($new_remaining < 0) {
        die("Error: Not enough stock for drug ID $drug_id. Remaining would be negative.");
    }

    // Update Approval_distributed_quantity
    $update_sql = "UPDATE item_distributions 
                   SET distributed_quantity = ? 
                   WHERE unit_id = ? AND item_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("dii", $new_remaining, $unit_id, $drug_id);
    if (!$update_stmt->execute()) {
        die("Update failed: " . $update_stmt->error);
    }
    $update_stmt->close();
}

$insert_stmt->close();

// ✅ Success message
echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Prescription saved and stock updated successfully.',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'add_prescription.php';
        });
    </script>";
exit;
