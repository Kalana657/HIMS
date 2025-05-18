<?php
include('db_connect.php');


$unit_id = $_POST['unit_id'] ?? null;
$selected_items = $_POST['selected_items'] ?? [];
$quantities = $_POST['qty'] ?? [];
$remarks = $_POST['remarks'] ?? [];


if (!$unit_id || empty($selected_items)) {
    echo "<script>
        alert('Please select a unit and at least one item.');
        window.history.back();
    </script>";
    exit;
}


$success_count = 0;
$failed_items = [];

foreach ($selected_items as $item_id) {
    $item_id = intval($item_id);
    $qty = intval($quantities[$item_id] ?? 0);
    $remark = mysqli_real_escape_string($conn, $remarks[$item_id] ?? '');

    if ($qty > 0) {
        $insert = "INSERT INTO item_distributions (unit_id, item_id, distributed_quantity, remarks)
                   VALUES ('$unit_id', '$item_id', '$qty', '$remark')";

        if (mysqli_query($conn, $insert)) {
            $success_count++;

          
            $update = "UPDATE inventory_item SET quantity = quantity - $qty WHERE item_id = $item_id AND quantity >= $qty";
            mysqli_query($conn, $update);
        } else {
            $failed_items[] = $item_id;
        }
    }
}


if ($success_count > 0) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Distributed!',
            text: '$success_count item(s) distributed successfully.',
            confirmButtonText: 'OK'
        }).then(() => window.location.href = 'distribution_page.php');
        </script>";
} else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        Swal.fire({
            icon: 'error',
            title: 'No Items Distributed',
            text: 'Please check your input and try again.',
            confirmButtonText: 'Back'
        }).then(() => window.history.back());
        </script>";
}
?>
