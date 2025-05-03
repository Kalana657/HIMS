<?php
include 'db_connect.php';

if (isset($_POST['category_id'])) {
    $category_id = intval($_POST['category_id']);

    $stmt = $conn->prepare("SELECT vendor_id, vendor_name FROM vendors WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<option value="">-- Select Vendor --</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['vendor_id'] . '">' . htmlspecialchars($row['vendor_name']) . '</option>';
    }

    $stmt->close();
    $conn->close();
}
?>
