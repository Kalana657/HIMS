<div class="col-lg-2 col-md-3 sidebar d-flex flex-column p-0">
     <div class="logo">
                <h3><i class="bi bi-heart-pulse me-2"></i>  
                <img src="../../../images/logo.jpeg" style="width:105px; height:75px;">


            
                 </h3>
                <p class="text-white-50 mb-0">Hospital Inventory Management System</p>
       </div>
  <ul class="nav flex-column flex-grow-1 pt-3">
    <!-- Dashboard -->
    <li class="nav-item">
      <a class="nav-link active" href="dsshboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    </li>

    
    <li class="nav-item">
      <a href="#submenuAddSection" class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="submenuAddSection">
        <span><i class="bi bi-box-seam"></i> Inventory</span>
        <i class="bi bi-chevron-down rotate-icon"></i>
      </a>
      <ul class="collapse list-unstyled ps-3" id="submenuAddSection">
        <li class="nav-item">
          <a href="Addnewitem.php" class="nav-link">
            <i class="bi bi-plus-square me-2"></i> Add New Item
          </a>
        </li>
        <li class="nav-item">
          <a href="Inventorytable.php" class="nav-link">
            <i class="bi bi-table me-2"></i> Inventory Table

          </a>
        </li>
          <li class="nav-item">
          <a href="UPInventorytable.php" class="nav-link">
            <i class="bi bi-arrow-repeat me-2"></i> Update Inventory Quntity

          </a>

        </li>

          <li class="nav-item">
          <a href="inventory_add_requests.php" class="nav-link">
            <i class="bi bi-arrow-repeat me-2"></i> Inventory Add Requests

          </a>

        </li>
        
      </ul>
    </li>

 

    <!-- Continue with the rest -->
    <li class="nav-item">
      <a class="nav-link" href="procurmenttable.php"><i class="bi bi-cart"></i> Procurement</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="Repairs.php"><i class="bi bi-tools"></i> Repairs</a>
    </li>
    
   
    <li class="nav-item">
    <a href="#submenuDistribution" class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="submenuDistribution">
        <span><i class="bi bi-truck me-2"></i> Distribution Management</span>
        <i class="bi bi-chevron-down rotate-icon"></i>
    </a>
    <ul class="collapse list-unstyled ps-3" id="submenuDistribution">
        <li class="nav-item">
        <a href="distribute_item_form.php" class="nav-link">
            <i class="bi bi-send-check me-2"></i> Distribution Form
        </a>
        </li>
        
    </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="qctable.php"><i class="bi bi-clipboard-check"></i> Quality Control</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#"><i class="bi bi-gift"></i> Donations</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#"><i class="bi bi-file-earmark-text"></i> Reports</a>
    </li>
    <li class="nav-item mt-auto">
      <a class="nav-link" href="#"><i class="bi bi-gear"></i> Settings</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </li>
  </ul>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggles = document.querySelectorAll('[data-bs-toggle="collapse"]');
    toggles.forEach(toggle => {
      const icon = toggle.querySelector('.rotate-icon');
      const target = document.querySelector(toggle.getAttribute('href'));

      target.addEventListener('shown.bs.collapse', () => icon.classList.add('open'));
      target.addEventListener('hidden.bs.collapse', () => icon.classList.remove('open'));
    });
  });
</script>
