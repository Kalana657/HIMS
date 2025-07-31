<?php
require '../vendor/autoload.php';
use Dompdf\Dompdf;

include 'db_connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Validate parameters
if (!isset($_GET['table']) || !isset($_GET['id'])) {
    die("Missing parameters.");
}

$table = mysqli_real_escape_string($conn, $_GET['table']);
$id = intval($_GET['id']);

// ✅ Get list of tables in the current database
$allowed_tables = [];
$table_result = mysqli_query($conn, "SHOW TABLES");
while ($row = mysqli_fetch_row($table_result)) {
    $allowed_tables[] = $row[0];
}

if (!in_array($table, $allowed_tables)) {
    die("Invalid table name.");
}

// Fetch record
$query = "SELECT * FROM `$table` WHERE id = $id";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) == 0) {
    die("No record found.");
}

$data = mysqli_fetch_assoc($result);

// Build HTML for PDF
$html = "<h2>Exported Document - Table: $table</h2><table border='1' cellpadding='5' cellspacing='0'>";
foreach ($data as $key => $value) {
    $html .= "<tr><th>" . htmlspecialchars($key) . "</th><td>" . htmlspecialchars($value) . "</td></tr>";
}
$html .= "</table>";

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("document_$id.pdf", ["Attachment" => false]);
?>
