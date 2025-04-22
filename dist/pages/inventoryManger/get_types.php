<?php
include('db_connect.php');

if (isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];
    $query = "SELECT type_id, type_name FROM inventory_type WHERE category_id = '$category_id'";
    $result = mysqli_query($conn, $query);
    
    echo '<option value="">Select Type</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['type_id'] . '">' . $row['type_name'] . '</option>';
    }
}
?>
