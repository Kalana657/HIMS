 <div class="sidebar">
            <div class="logo">
                <h3><i class="bi bi-heart-pulse me-2"></i>  
                <img src="../../../images/logo.jpeg" style="width:105px; height:75px;">


            
                 </h3>
                <p class="text-white-50 mb-0">Hospital Inventory Management System</p>
            </div>
            <ul class="nav flex-column mt-4">
                <li class="nav-item">
                    <a class="nav-link active" href="dsshboard.php">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="#inventorySubMenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="bi bi-box-seam"></i>
                        <span>Inventory</span>
                        <i class="bi bi-chevron-down float-end"></i>
                        <span class="badge bg-danger rounded-pill">42</span>
                    </a>
                    <ul class="collapse list-unstyled ps-4" id="inventorySubMenu">
                        <li><a class="nav-link" href="AllInmvetory.php">All Items</a></li>
                        <li><a class="nav-link" href="inventory_add_requests.php">Inventory Add Requests</a></li>
                        <li><a class="nav-link" href="#">Categories</a></li>
                        <li><a class="nav-link" href="#">Vendors</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="procurmentable.php">
                        <i class="bi bi-cart-plus"></i>
                        <span>Procurement</span>
                        <span class="badge bg-warning rounded-pill">18</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-tools"></i>
                        <span>Repairs</span>
                        <span class="badge bg-info rounded-pill">9</span>
                    </a>
                </li>
                
               <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" href="#usersSubMenu" data-bs-toggle="collapse" aria-expanded="false">
                        <span><i class="bi bi-people me-2"></i>User Mangement</span>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                     <ul class="collapse list-unstyled ps-4" id="usersSubMenu">
                        <li><a class="nav-link " href="Addnewuser.php"> Add New User</a></li>
                        <li><a class="nav-link " href="Addnewrole.php"> Add New User Role</a></li>
                        <li><a class="nav-link " href="Add_unit.php"> Add Unit/Wards</a></li>
                        <li><a class="nav-link " href="#">Permissions</a></li>
                    </ul>
                </li>



                <li class="nav-item">
                    <a class="nav-link" href="Distribute_req_table.php">
                        <i class="bi bi-truck"></i>
                        <span>Distribution</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-clipboard-check"></i>
                        <span>Quality Control</span>
                        <span class="badge bg-danger rounded-pill">7</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-gift"></i>
                        <span>Donations</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <li class="nav-item mt-4">
                    <a class="nav-link" href="#">
                        <i class="bi bi-gear"></i>
                        <span>Settings</span>
                    </a>
                </li>
                 <li class="nav-item">
                        <a class="nav-link" href="logout.php" data-section="logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </li>
            </ul>
        </div>