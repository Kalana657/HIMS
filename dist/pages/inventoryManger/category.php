<?php
include('db_connect.php');

// Query to get categories from the inventory_category table
$query = "SELECT * FROM inventory_category";
$result = mysqli_query($conn, $query);

// Check if the query ran successfully
if (!$result) {
    echo json_encode(["error" => mysqli_error($conn)]);
    exit;
}

$categories = [];
// Fetch each category and store it in the $categories array
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}

// Return the categories as a JSON object
echo json_encode($categories);
?>
