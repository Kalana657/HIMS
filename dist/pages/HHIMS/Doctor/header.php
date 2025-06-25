 <?php
 include('db_connect.php'); 

$unitName = "HIMS"; // Default value
if (isset($_SESSION['unitin_id']) && isset($_SESSION['user_id'])) {
    $unitQuery = "SELECT units.unit_name
                  FROM units
                  JOIN user ON units.unit_id = user.unitin_id
                  WHERE user.User_id = ?";
    $stmt = $conn->prepare($unitQuery);
    $stmt->bind_param("i", $_SESSION['user_id']); // Use user_id from session
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $unit = $result->fetch_assoc();
        $unitName = $unit['unit_name'];
    }
    $stmt->close();
}               
 $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$email = isset($_SESSION['Email']) ? $_SESSION['Email'] : 'N/A';
$userInitials = isset($_SESSION['username']) ? strtoupper(substr($username, 0, 2)) : 'GU';     
?>
                
                
                <div class="header">
                    <div class="header-title">
                       
                    </div>
                    <div class="header-actions">
                        <div class="search-bar">
                            <i class="fas fa-search text-muted"></i>
                            <input type="text" placeholder="Search patients, drugs...">
                        </div>
                        <div class="user-profile">
                            <div class="user-info">
                                <div class="name">Dr.<?php echo htmlspecialchars($username)?> </div>
                               <div class="unit"> <?php echo htmlspecialchars($unitName)?> </div>

                             
                            </div>
                            <div class="user-avatar">S<?php echo htmlspecialchars($userInitials)?></div>
                        </div>
                    </div>
                </div>
