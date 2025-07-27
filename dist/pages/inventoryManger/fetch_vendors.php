<?php
include('db_connect.php');
$item_id = $_POST['item_id'];
$stmt = $conn->prepare("SELECT * FROM vendors WHERE item_id = ?");
$stmt->bind_param("i", $item_id);
$stmt->execute();
$result = $stmt->get_result();
$vendors = [];
while ($row = $result->fetch_assoc()) {
    $vendors[] = $row;
}
echo json_encode($vendors);
$stmt->close();