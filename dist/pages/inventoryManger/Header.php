<div class="header d-flex flex-wrap align-items-center justify-content-between">
    <div>
        <h2 class="mb-0">Inventory Dashboard</h2>
        <p class="text-muted mb-0"></p>
    </div>
    <div class="d-flex align-items-center">
        <div class="input-group search-bar me-3">
            <input type="text" class="form-control" placeholder="Search inventory...">
            <button class="btn btn-primary" type="button">
                <i class="bi bi-search"></i>
            </button>
        </div>

       <?php
                include('db_connect.php');

                // Get unread count
                $notificationCount = 0;
                $countQuery = mysqli_query($conn, "SELECT COUNT(*) AS count FROM notifications WHERE status = 'unread'");
                if ($countQuery) {
                    $countRow = mysqli_fetch_assoc($countQuery);
                    $notificationCount = $countRow['count'];
                }

                // Get all notifications
                $allQuery = mysqli_query($conn, "SELECT id, item_id, message, status, created_at FROM notifications ORDER BY created_at DESC");
                ?>

                <div class="dropdown">
                    <button class="btn btn-light position-relative" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell" style="font-size: 1.5rem;"></i>
                        <?php if ($notificationCount > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notifCountBadge">
                                <?= $notificationCount ?>
                                <span class="visually-hidden">unread notifications</span>
                            </span>
                        <?php endif; ?>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="notificationDropdown" style="min-width: 320px; max-height: 400px; overflow-y: auto;" id="notificationsList">
                        <li class="dropdown-header fw-bold">Notifications</li>
                        <?php
                        if ($allQuery && mysqli_num_rows($allQuery) > 0) {
                            while ($row = mysqli_fetch_assoc($allQuery)) {
                                $isUnread = ($row['status'] === 'unread');
                                ?>
                                <li
                                    class="notification-item mb-2 p-2 rounded <?= $isUnread ? 'bg-light' : '' ?>"
                                    style="cursor: pointer;"
                                    data-id="<?= $row['id'] ?>"
                                >
                                    <div><strong>Item ID:</strong> <?= htmlspecialchars($row['item_id']) ?></div>
                                    <div><?= htmlspecialchars($row['message']) ?></div>
                                    <small class="text-muted"><?= date('d M Y, H:i', strtotime($row['created_at'])) ?></small>
                                </li>
                                <hr class="my-1">
                                <?php
                            }
                        } else {
                            echo '<li class="text-center text-muted">No notifications found.</li>';
                        }
                        ?>
                    </ul>
                </div>

               
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                <script>
                $(document).ready(function() {
                    // When notification item clicked
                    $('.notification-item').click(function() {
                        var notificationId = $(this).data('id');
                        var $this = $(this);

                        // AJAX request to mark as read
                        $.ajax({
                            url: 'mark_notification_read.php',
                            type: 'POST',
                            data: { id: notificationId },
                            success: function(response) {
                                // On success, update UI: remove bg-light highlight and update count badge
                                if (response === 'success') {
                                    $this.removeClass('bg-light');
                                    
                                    // Update unread count badge
                                    var badge = $('#notifCountBadge');
                                    var count = parseInt(badge.text());
                                    if (count > 1) {
                                        badge.text(count - 1);
                                    } else {
                                        badge.remove();
                                    }
                                } else {
                                    alert('Failed to update notification status.');
                                }
                            },
                            error: function() {
                                alert('Error in AJAX request.');
                            }
                        });
                    });
                });
                </script>


        <div class="dropdown ms-3">
            <div class="d-flex align-items-center" data-bs-toggle="dropdown" style="cursor: pointer;">
                <div class="user-avatar me-2 rounded-circle bg-primary text-white d-flex justify-content-center align-items-center" style="width: 36px; height: 36px;">IM</div>
                <div>
                    <p class="mb-0 fw-medium"><?= htmlspecialchars($_SESSION['username']); ?></p>
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
