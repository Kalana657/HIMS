   <div class="header d-flex flex-wrap align-items-center justify-content-between">
                    <div>
                        <h2 class="mb-0">Inventory Dashboard</h2>
                        <p class="text-muted mb-0"></p>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="input-group search-bar">
                            <input type="text" class="form-control" placeholder="Search inventory...">
                            <button class="btn btn-primary" type="button">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <div class="ms-3 position-relative">
                            <button class="btn btn-light position-relative" data-bs-toggle="modal" data-bs-target="#notificationModal">
                                <i class="bi bi-bell fs-5"></i>
                                <span class="notification-badge">5</span>
                            </button>
                        </div>
                        <div class="dropdown ms-3">
                            <div class="d-flex align-items-center" data-bs-toggle="dropdown">
                                <div class="user-avatar me-2">IM</div>
                                <div>
                                    <p class="mb-0 fw-medium"><?= $_SESSION['username']; ?></p>
                                    <small class="text-muted">Inventory Manager</small>
                                </div>
                            </div>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>