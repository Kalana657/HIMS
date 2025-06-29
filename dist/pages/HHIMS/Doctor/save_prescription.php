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
$sql = "INSERT INTO prescriptions 
        (patient_id, unit_id, drug_id, drug_qte, date_prescribed, diagnosis, notes, prescribed_by, created_at)
        VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

foreach ($drug_ids as $index => $drug_id) {
    $drug_id = intval($drug_id);
    if ($drug_id <= 0) continue;

    $dose = floatval($doses[$index] ?? 0);
    $frequency = $frequencies[$index] ?? '';
    $duration = $durations[$index] ?? '';

    // Convert frequency and duration to numeric values
    // Frequency mapping (you may adjust this according to your select options)
    $freq_map = [
        "Once daily" => 1,
        "Twice daily" => 2,
        "Thrice daily" => 3,
        "Every 6 hours" => 4,
        "As needed" => 1, // treat as 1 for quantity calculation, or 0 if you want to exclude
        "1" => 1,
        "2" => 2,
        "3" => 3,
        "4" => 4,
    ];

    $freq_num = $freq_map[$frequency] ?? 1;

    // Duration might be string like "3 days" or just numbers like "3"
    // Extract numeric part:
    preg_match('/\d+/', $duration, $matches);
    $duration_num = isset($matches[0]) ? intval($matches[0]) : 1;

    $total_quantity = $dose * $freq_num * $duration_num;

    // Bind and execute insert statement
    $stmt->bind_param(
        "iiiisss",
        $patient_id,
        $unit_id,
        $drug_id,
        $total_quantity,
        $diagnosis,
        $notes,
        $prescribed_by
    );

    if (!$stmt->execute()) {
        die("Insert failed: " . $stmt->error);
    }
}

$stmt->close();

header("Location: add_prescription.php"); // redirect after success
exit;
