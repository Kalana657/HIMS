
<?PHP
session_start();
include('db_connect.php');

if (!isset($_SESSION['unitin_id'])) {
    die("Access denied. Please login first.");
}
$unit_id = $_SESSION['unitin_id'];

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid access.");
}

$patient_id = intval($_POST['patient_id']);
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

if (empty($diagnosis) || empty($prescribed_by) || empty($drug_ids)) {
    die("Please fill all required fields.");
}

$count_drugs = count($drug_ids);
if (
    $count_drugs !== count($doses) || 
    $count_drugs !== count($frequencies) || 
    $count_drugs !== count($durations) || 
    $count_drugs !== count($routes) || 
    $count_drugs !== count($instructions)
) {
    die("Mismatched input arrays.");
}

$conn->begin_transaction();

try {
    $insert_sql = "INSERT INTO prescriptions 
        (patient_id, unit_id, drug_id, drug_qte, date_prescribed, diagnosis, notes, prescribed_by, created_at)
        VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, NOW())";
    $insert_stmt = $conn->prepare($insert_sql);
    if (!$insert_stmt) {
        throw new Exception("Prepare failed (insert): " . $conn->error);
    }

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

    for ($i = 0; $i < $count_drugs; $i++) {
        $drug_id = intval($drug_ids[$i]);
        if ($drug_id <= 0) continue;

        $dose = floatval($doses[$i]);
        $frequency = $frequencies[$i];
        $duration = $durations[$i];

        $freq_num = $freq_map[$frequency] ?? 1;
        preg_match('/\d+/', $duration, $matches);
        $duration_num = isset($matches[0]) ? intval($matches[0]) : 1;

        $total_quantity = $dose * $freq_num * $duration_num;

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
            throw new Exception("Insert failed: " . $insert_stmt->error);
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

        $new_remaining = $distributed_qty - $total_prescribed;

        if ($new_remaining < 0) {
            throw new Exception("Not enough stock for drug ID $drug_id.");
        }

        // Update distributed_quantity
        $update_sql = "UPDATE item_distributions 
                       SET distributed_quantity = ? 
                       WHERE unit_id = ? AND item_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("dii", $new_remaining, $unit_id, $drug_id);
        if (!$update_stmt->execute()) {
            throw new Exception("Update failed: " . $update_stmt->error);
        }
        $update_stmt->close();
    }

    $insert_stmt->close();
    $conn->commit();

    $_SESSION['status'] = 'success';
    $_SESSION['message'] = 'Prescription saved and stock updated successfully.';
    header("Location: add_prescription.php?pid=" . $patient_id);
    exit();

} catch (Exception $e) {
    $conn->rollback();
    die("Transaction failed: " . $e->getMessage());
}
