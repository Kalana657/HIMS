<?php
include('db_connect.php');

if (isset($_POST['type_id'])) {
    $type_id = $_POST['type_id'];
    $query = "SELECT subtype_id, subtype_name FROM inventory_subtype WHERE type_id = '$type_id'";
    $result = mysqli_query($conn, $query);
    
    echo '<option value="">Select Subtype</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['subtype_id'] . '">' . $row['subtype_name'] . '</option>';
    }
}
?>
