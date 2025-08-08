<?php
session_start();
include('db_connect.php');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>HIMS | Procurement Table</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <style>
        .card-title { font-size: 1.1rem; font-weight: 600; }
        .badge.bg-danger { font-size: 0.85rem; padding: 0.4em 0.6em; border-radius: 12px; }
        .card-body button { width: 48%; }
    </style>
</head>
<body class="bg-light">
<div class="container-fluid">
    <div class="row">
        <?php include('Slidebari.php'); ?>
        <div class="col-lg-10 col-md-9 main-content">
            <?php include('Header.php'); ?>

            <div class="d-flex justify-content-between align-items-center my-4">
                <h3><i class="bi bi-cart-check-fill text-primary"></i> Procurement Dashboard</h3>
                <input type="search" class="form-control w-25" id="searchInput" placeholder="Search items...">
            </div>

            <?php
            if (isset($_SESSION['status']) && isset($_SESSION['message'])) {
                echo "<script>
                    Swal.fire({
                        icon: '" . htmlspecialchars($_SESSION['status']) . "',
                        title: '" . ucfirst(htmlspecialchars($_SESSION['status'])) . "!',
                        text: '" . htmlspecialchars($_SESSION['message']) . "',
                        confirmButtonText: 'OK'
                    });
                </script>";
                unset($_SESSION['status'], $_SESSION['message']);
            }

            $query = "
              SELECT 
                        inventory_item.*,
                        inventory_category.category_name,
                        inventory_type.type_name,
                        inventory_subtype.subtype_name,
                        item_approvals.approved_quantity,
                        item_approvals.comment
                       
                    FROM inventory_item
                    JOIN inventory_category ON inventory_item.category_id = inventory_category.category_id
                    JOIN inventory_type ON inventory_item.type_id = inventory_type.type_id
                    JOIN inventory_subtype ON inventory_item.subtype_id = inventory_subtype.subtype_id
                    LEFT JOIN item_approvals ON inventory_item.item_id = item_approvals.approval_id
                    WHERE inventory_item.category_id = 2 
                    AND inventory_item.status = 1
                    AND  inventory_item.quantity <= item_approvals.approved_quantity *0.2
                    

            ";

            $result = mysqli_query($conn, $query);
            $items = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $items[] = $row;
            }
            ?>

            <div class="row">
                <?php foreach ($items as $index => $row): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-capsule text-primary"></i>
                                        <?= htmlspecialchars($row['item_name'])  ?>
                                    
                                    </h5>
                                    <span class="badge bg-danger">
                                        <i class="bi bi-exclamation-circle"></i> <?= $row['quantity'] ?>
                                    </span>
                                </div>
                                <p class="mb-1 text-muted"><i class="bi bi-tag-fill text-warning"></i>
                                    <?= $row['category_name'] ?> > <?= $row['type_name'] ?> > <?= $row['subtype_name'] ?>
                                </p>

                                <div class="mt-3 d-flex justify-content-between">
                                    
                                    <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#poModal<?= $row['item_id'] ?>">
                                        <i class="bi bi-file-plus-fill"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PO Modal -->
                    <div class="modal fade" id="poModal<?= $row['item_id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <form method="post" action="generate_po.php">
                                <input type="hidden" name="item_id" value="<?= $row['item_id'] ?>">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title"><i class="bi bi-cart-check"></i> Generate Purchase Order</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <?php
                                    // Fetch total prescribed quantity from prescriptions table for the current item (drug)
                                    $prescribed_result = mysqli_query($conn, "
                                        SELECT SUM(drug_qte) AS total_prescribed
                                        FROM prescriptions
                                        WHERE drug_id = {$row['item_id']}
                                    ");
                                    $prescribed_data = mysqli_fetch_assoc($prescribed_result);
                                    $suggested_qty = isset($prescribed_data['total_prescribed']) ? $prescribed_data['total_prescribed'] * 10 : 10;


                                    ?>

 




                                    <div class="modal-body row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Suggested Quantity</label>
                                            <input type="number" class="form-control" name="suggested_qty" value="<?= $suggested_qty ?>" required>

                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Select Vendor</label>
                                            <select class="form-select" name="vendor_id" required>
                                                <?php
                                                $vendors = mysqli_query($conn, "SELECT * FROM vendors WHERE item_id = {$row['item_id']} ORDER BY item_price ASC");
                                                $first = true;
                                                while ($v = mysqli_fetch_assoc($vendors)):
                                                ?>
                                                    <option value="<?= $v['vendor_id'] ?>" <?= $first ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($v['vendor_name']) ?> - Rs.<?= number_format($v['item_price'], 2) ?>/unit
                                                    </option>
                                                <?php
                                                    $first = false;
                                                endwhile;
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="border rounded p-3 mt-2 bg-light">
                                                <h6 class="text-muted">System Estimation:</h6>
                                                <ul class="list-unstyled mb-0">
                                                    <li><i class="bi bi-bar-chart-line"></i> Demand Forecast: <strong>10 units/month</strong></li>
                                                    <li><i class="bi bi-person-check-fill"></i> Best Vendor: <strong id="best_vendor_<?= $row['item_id'] ?>">—</strong></li>
                                                    <li><i class="bi bi-cash-stack"></i> Estimated Cost: <strong id="estimated_cost_<?= $row['item_id'] ?>">$0.00</strong></li>
                                                   
                                                   

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success"><i class="bi bi-check-circle"></i> Generate PO</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const modals = document.querySelectorAll('[id^="poModal"]');

    modals.forEach(modal => {
        const itemId = modal.id.replace('poModal', '');

        const qtyInput = modal.querySelector(`input[name='suggested_qty']`);
        const vendorSelect = modal.querySelector(`select[name='vendor_id']`);
        const costSpan = modal.querySelector(`#estimated_cost_${itemId}`);
        const bestVendorSpan = modal.querySelector(`#best_vendor_${itemId}`);

        function updateEstimation() {
            const qty = parseFloat(qtyInput.value) || 0;
            const selectedOption = vendorSelect.selectedOptions[0];

            if (selectedOption && selectedOption.value !== "") {
                const priceText = selectedOption.textContent.split("Rs")[1];
                const price = parseFloat(priceText);
                if (!isNaN(price)) {
                    const total = price * qty;
                    costSpan.textContent = "Rs" + total.toFixed(2);
                    bestVendorSpan.textContent = selectedOption.textContent.split("-")[0].trim();
                    return;
                }
            }

            costSpan.textContent = "$0.00";
            bestVendorSpan.textContent = "—";
        }

        modal.addEventListener("shown.bs.modal", function () {
            updateEstimation();
        });

        qtyInput.addEventListener("input", updateEstimation);
        vendorSelect.addEventListener("change", updateEstimation);
    });
});
</script>

</body>
</html>
