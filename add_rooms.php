<?php
require_once 'config.php';
date_default_timezone_set('Asia/Manila');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header('Location: login.php');
    exit();
}

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $room_number = trim($_POST['room_number']);
        $room_type_id = $_POST['room_type_id'];
        $floor = $_POST['floor'];
        
        if (!preg_match('/^\d{1,3}$/', $room_number)) {
            $_SESSION['error'] = "Room number must be 1-3 digits only!";
        } elseif (!preg_match('/^\d{1,3}$/', $floor)) {
            $_SESSION['error'] = "Floor must be 1-3 digits only!";
        } else {
            $stmt = $conn->prepare("CALL sp_add_room(?, ?, ?, @result)");
            $stmt->bind_param("sis", $room_number, $room_type_id, $floor);
            $stmt->execute();
            $stmt->close();
            
            $result = $conn->query("SELECT @result as result");
            $row = $result->fetch_assoc();
            $message = $row['result'];
            
            if (strpos($message, 'SUCCESS:') === 0) {
                $_SESSION['success'] = substr($message, 8);
            } else {
                $_SESSION['error'] = substr($message, 6);
            }
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'add_room_type') {
        $type_name = trim($_POST['type_name']);
        $description = trim($_POST['description']);
        $base_price = $_POST['base_price'];
        $max_occupancy = $_POST['max_occupancy'];
        
        $image_path = null;
        
        if (empty($type_name)) {
            $_SESSION['error'] = "Room type name is required!";
        } elseif (strlen($type_name) > 20) {
            $_SESSION['error'] = "Room type name must not exceed 20 characters!";
        } elseif (strlen($description) > 50) {
            $_SESSION['error'] = "Description must not exceed 50 characters!";
        } elseif (!preg_match('/^\d{1,5}(\.\d{1,2})?$/', $base_price)) {
            $_SESSION['error'] = "Base price must be 1-5 digits!";
        } elseif ($max_occupancy < 1 || $max_occupancy > 99 || !preg_match('/^\d{1,2}$/', $max_occupancy)) {
            $_SESSION['error'] = "Max occupancy must be 1-2 digits!";
        } else {
            if (isset($_FILES['room_image']) && $_FILES['room_image']['error'] === UPLOAD_ERR_OK) {
                $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
                $max_size = 5 * 1024 * 1024;
                
                if (!in_array($_FILES['room_image']['type'], $allowed_types)) {
                    $_SESSION['error'] = "Only JPG, JPEG, and PNG images are allowed!";
                } elseif ($_FILES['room_image']['size'] > $max_size) {
                    $_SESSION['error'] = "Image size must not exceed 5MB!";
                } else {
                    $upload_dir = 'uploads/room_types/';
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    
                    $file_extension = pathinfo($_FILES['room_image']['name'], PATHINFO_EXTENSION);
                    $file_name = uniqid('room_') . '.' . $file_extension;
                    $image_path = $upload_dir . $file_name;
                    
                    if (!move_uploaded_file($_FILES['room_image']['tmp_name'], $image_path)) {
                        $_SESSION['error'] = "Failed to upload image!";
                        $image_path = null;
                    }
                }
            }
            
            if (!isset($_SESSION['error'])) {
                $stmt = $conn->prepare("CALL sp_add_room_type(?, ?, ?, ?, ?, @result)");
                $stmt->bind_param("ssdis", $type_name, $description, $base_price, $max_occupancy, $image_path);
                $stmt->execute();
                $stmt->close();
                
                $result = $conn->query("SELECT @result as result");
                $row = $result->fetch_assoc();
                $message = $row['result'];
                
                if (strpos($message, 'SUCCESS:') === 0) {
                    $_SESSION['success'] = substr($message, 8);
                } else {
                    $_SESSION['error'] = substr($message, 6);
                    if ($image_path && file_exists($image_path)) {
                        unlink($image_path);
                    }
                }
            }
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'archive_room') {
        $room_id = $_POST['room_id'];
        $is_archived = $_POST['is_archived'];
        
        if ($is_archived == 0) {
            $check_stmt = $conn->prepare("SELECT rt.is_archived FROM rooms r JOIN room_types rt ON r.room_type_id = rt.room_type_id WHERE r.room_id = ?");
            $check_stmt->bind_param("i", $room_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            $check_row = $check_result->fetch_assoc();
            $check_stmt->close();
            
            if ($check_row && $check_row['is_archived'] == 1) {
                $_SESSION['error'] = "Cannot restore room: Room type is archived!";
                header("Location: add_rooms.php");
                exit();
            }
        }
        
        $stmt = $conn->prepare("CALL sp_archive_room(?, ?, @result)");
        $stmt->bind_param("ii", $room_id, $is_archived);
        $stmt->execute();
        $stmt->close();
        
        $result = $conn->query("SELECT @result as result");
        $row = $result->fetch_assoc();
        $message = $row['result'];
        
        if (strpos($message, 'SUCCESS:') === 0) {
            $_SESSION['success'] = substr($message, 8);
        } else {
            $_SESSION['error'] = substr($message, 6);
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'archive_room_type') {
        $room_type_id = $_POST['room_type_id'];
        $is_archived = $_POST['is_archived'];
        
        $stmt = $conn->prepare("CALL sp_archive_room_type(?, ?, @result)");
        $stmt->bind_param("ii", $room_type_id, $is_archived);
        $stmt->execute();
        $stmt->close();
        
        $result = $conn->query("SELECT @result as result");
        $row = $result->fetch_assoc();
        $message = $row['result'];
        
        if (strpos($message, 'SUCCESS:') === 0) {
            $_SESSION['success'] = substr($message, 8);
        } else {
            $_SESSION['error'] = substr($message, 6);
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'maintenance') {
        $room_id = $_POST['room_id'];
        $maintenance_status = $_POST['maintenance_status'];
        
        $stmt = $conn->prepare("CALL sp_update_room_status(?, ?, @result)");
        $stmt->bind_param("is", $room_id, $maintenance_status);
        $stmt->execute();
        $stmt->close();
        
        $result = $conn->query("SELECT @result as result");
        $row = $result->fetch_assoc();
        $message = $row['result'];
        
        if (strpos($message, 'SUCCESS:') === 0) {
            $_SESSION['success'] = substr($message, 8);
        } else {
            $_SESSION['error'] = substr($message, 6);
        }
    }
    
    header("Location: add_rooms.php");
    exit();
}

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

$total_rooms_result = $conn->query("SELECT count FROM vw_room_count");
$total_rooms_row = $total_rooms_result->fetch_assoc();
$total_rooms = $total_rooms_row['count'];
$total_pages = ceil($total_rooms / $per_page);

$rooms = $conn->query("SELECT room_id, room_number, type_name, floor, status FROM vw_active_rooms LIMIT $offset, $per_page");

$room_types = $conn->query("SELECT room_type_id, type_name, description, base_price, max_occupancy FROM vw_all_room_types ORDER BY type_name");

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="css/staff_rooms.css">
    <link rel="stylesheet" href="css/add_rooms.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Rooms - Hotel Reservation System</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
            padding: 20px 0;
        }
        
        .pagination button {
            padding: 8px 16px;
            border: 1px solid #ddd;
            background: white;
            color: #333;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .pagination button:hover:not(:disabled) {
            background: #2c3e50;
            color: white;
            border-color: #2c3e50;
        }
        
        .pagination button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .pagination button.active {
            background: #2c3e50;
            color: white;
            border-color: #2c3e50;
        }
        
        .pagination .page-info {
            font-weight: 500;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="fas fa-hotel"></i>
                <h2 class="playfair">LuxeStay</h2>
            </div>
            <div class="user-info">
                <h3><?php echo htmlspecialchars($_SESSION['full_name']); ?></h3>
                <p><i class="fas fa-user-tie"></i> Staff Member</p>
            </div>
        </div>
        
        <div class="sidebar-menu">
            <a href="staff_dashboard.php" class="menu-item">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            <a href="manage_bookings.php" class="menu-item">
                <i class="fas fa-calendar-check"></i>
                <span>Manage Bookings</span>
            </a>
            <a href="staff_rooms.php" class="menu-item">
                <i class="fas fa-door-open"></i>
                <span>Rooms</span>
            </a>
            <a href="add_rooms.php" class="menu-item">
                <i class="fas fa-plus"></i>
                <span>Manage Rooms</span>
            </a>
            
            <div class="menu-divider"></div>
            
            <a href="index.php" class="menu-item">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a href="logout.php" class="menu-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
    
    <div class="main-content">
        <div class="top-bar">
            <div class="top-bar-left">
                <h1 class="playfair">Manage Rooms</h1>
                <div class="breadcrumb">
                    <span>Home</span>
                    <i class="fas fa-chevron-right"></i>
                    <span>Manage Rooms</span>
                </div>
            </div>
            <div class="top-bar-right">
                <div class="date-time">
                    <p><?php echo date('l'); ?></p>
                    <h4><?php echo date('F d, Y'); ?></h4>
                </div>
            </div>
        </div>
        
        <div class="container">
            <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></span>
            </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
            </div>
            <?php endif; ?>

            <div class="action-buttons">
                <button class="btn-add" onclick="openModal('addRoomModal')">
                    <i class="fas fa-door-open"></i>
                    Add New Room
                </button>
                <button class="btn-add" onclick="openModal('addRoomTypeModal')">
                    <i class="fas fa-layer-group"></i>
                    Add New Room Type
                </button>
            </div>
            
            <div class="section">
                <div class="section-header">
                    <h3 class="playfair"><i class="fas fa-door-open"></i> All Rooms</h3>
                    <div class="toggle-switch-container">
                        <span id="toggleLabel">Active</span>
                        <label class="toggle-switch">
                            <input type="checkbox" id="archiveToggle">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>
                
                <div id="roomsContainer">
                    <div class="table-container">
                        <table id="roomsTable">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-door-closed"></i> Room Number</th>
                                    <th><i class="fas fa-bed"></i> Type</th>
                                    <th><i class="fas fa-building"></i> Floor</th>
                                    <th><i class="fas fa-toggle-on"></i> Status</th>
                                    <th><i class="fas fa-cog"></i> Action</th>
                                </tr>
                            </thead>
                            <tbody id="roomsBody">
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination" id="roomsPagination"></div>
                </div>
            </div>

            <div class="section">
                <div class="section-header">
                    <h3 class="playfair"><i class="fas fa-layer-group"></i> Room Types</h3>
                    <div class="toggle-switch-container">
                        <span id="toggleLabelTypes">Active</span>
                        <label class="toggle-switch">
                            <input type="checkbox" id="archiveToggleTypes">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <div id="roomTypesContainer">
                    <div class="table-container">
                        <table id="roomTypesTable">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-bed"></i> Room Type</th>
                                    <th><i class="fas fa-users"></i> Max Occupancy</th>
                                    <th><i class="fas fa-dollar-sign"></i> Base Price</th>
                                    <th><i class="fas fa-info-circle"></i> Description</th>
                                    <th><i class="fas fa-cog"></i> Action</th>
                                </tr>
                            </thead>
                            <tbody id="roomTypesBody">
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination" id="roomTypesPagination"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="addRoomModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="playfair"><i class="fas fa-plus-circle"></i> Add New Room</h3>
                <span class="close" onclick="closeModal('addRoomModal')">&times;</span>
            </div>
            <div class="modal-body">
                <form method="POST" action="add_rooms.php">
                    <input type="hidden" name="action" value="add">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="room_number">Room Number</label>
                            <input type="text" id="room_number" name="room_number" placeholder="e.g., 101" maxlength="3" pattern="\d{1,3}" required>
                        </div>
                        <div class="form-group">
                            <label for="room_type_id">Room Type</label>
                            <select id="room_type_id" name="room_type_id" required>
                                <option value="">Select Room Type</option>
                                <?php 
                                $db_temp = new Database();
                                $conn_temp = $db_temp->getConnection();
                                $room_types_reset = $conn_temp->query("SELECT room_type_id, type_name FROM vw_active_room_types");
                                while ($type = $room_types_reset->fetch_assoc()): ?>
                                <option value="<?php echo $type['room_type_id']; ?>"><?php echo htmlspecialchars($type['type_name']); ?></option>
                                <?php endwhile;
                                $db_temp->close();
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="floor">Floor</label>
                        <input type="text" id="floor" name="floor" placeholder="e.g., 1" maxlength="3" pattern="\d{1,3}" required>
                    </div>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-plus"></i> Add Room
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div id="addRoomTypeModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="playfair"><i class="fas fa-plus-circle"></i> Add New Room Type</h3>
                <span class="close" onclick="closeModal('addRoomTypeModal')">&times;</span>
            </div>
            <div class="modal-body">
                <form method="POST" action="add_rooms.php" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="add_room_type">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="type_name">Room Type Name</label>
                            <input type="text" id="type_name" name="type_name" placeholder="e.g., Deluxe" maxlength="20" required>
                        </div>
                        <div class="form-group">
                            <label for="max_occupancy">Max Occupancy</label>
                            <input type="number" id="max_occupancy" name="max_occupancy" placeholder="e.g., 2" min="1" max="99" required oninput="if(this.value.length > 2) this.value = this.value.slice(0, 2);">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="base_price">Base Price</label>
                            <input type="number" id="base_price" name="base_price" placeholder="e.g., 2500.00" step="0.01" min="0" max="99999.99" required oninput="if(this.value.length > 8) this.value = this.value.slice(0, 8);">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" placeholder="e.g., Spacious room with premium amenities" maxlength="50"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="room_image">Room Image</label>
                        <input type="file" id="room_image" name="room_image" accept="image/jpeg,image/png,image/jpg" required>
                        <small style="color: #666; font-size: 0.85em;">Max 5MB. Allowed formats: JPG, JPEG, PNG</small>
                    </div>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-plus"></i> Add Room Type
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const archiveToggle = document.getElementById('archiveToggle');
        const toggleLabel = document.getElementById('toggleLabel');
        const roomsBody = document.getElementById('roomsBody');
        const archiveToggleTypes = document.getElementById('archiveToggleTypes');
        const toggleLabelTypes = document.getElementById('toggleLabelTypes');
        const roomTypesBody = document.getElementById('roomTypesBody');

        let currentRoomsPage = 1;
        let currentRoomTypesPage = 1;
        const roomsPerPage = 10;
        const roomTypesPerPage = 5;

        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }

        let allActiveRooms = <?php 
            $db = new Database();
            $conn = $db->getConnection();
            $active_result = $conn->query("SELECT r.room_id, r.room_number, rt.type_name, r.floor, r.status, rt.is_archived as room_type_archived FROM vw_active_rooms r JOIN rooms rm ON r.room_id = rm.room_id JOIN room_types rt ON rm.room_type_id = rt.room_type_id");
            $active_data = [];
            while ($row = $active_result->fetch_assoc()) {
                $active_data[] = $row;
            }
            echo json_encode($active_data);
        ?>;
        
        let allArchivedRooms = <?php 
            $archived_result = $conn->query("SELECT r.room_id, r.room_number, rt.type_name, r.floor, r.status, rt.is_archived as room_type_archived FROM vw_archived_rooms r JOIN rooms rm ON r.room_id = rm.room_id JOIN room_types rt ON rm.room_type_id = rt.room_type_id");
            $archived_data = [];
            while ($row = $archived_result->fetch_assoc()) {
                $archived_data[] = $row;
            }
            echo json_encode($archived_data);
        ?>;

        let allActiveRoomTypes = <?php 
            $active_types_result = $conn->query("SELECT room_type_id, type_name, description, base_price, max_occupancy FROM vw_active_room_types");
            $active_types_data = [];
            while ($row = $active_types_result->fetch_assoc()) {
                $active_types_data[] = $row;
            }
            echo json_encode($active_types_data);
        ?>;

        let allArchivedRoomTypes = <?php 
            $archived_types_result = $conn->query("SELECT room_type_id, type_name, description, base_price, max_occupancy FROM vw_archived_room_types");
            $archived_types_data = [];
            while ($row = $archived_types_result->fetch_assoc()) {
                $archived_types_data[] = $row;
            }
            $db->close();
            echo json_encode($archived_types_data);
        ?>;

        archiveToggle.addEventListener('change', function() {
            currentRoomsPage = 1;
            renderRoomsTable(this.checked);
        });

        archiveToggleTypes.addEventListener('change', function() {
            currentRoomTypesPage = 1;
            renderRoomTypesTable(this.checked);
        });

        function renderRoomsPagination(totalRooms, showArchived) {
            const totalPages = Math.ceil(totalRooms / roomsPerPage);
            const paginationContainer = document.getElementById('roomsPagination');
            
            if (totalPages <= 1) {
                paginationContainer.innerHTML = '';
                return;
            }
            
            let html = '';
            
            html += `<button onclick="changeRoomsPage(${currentRoomsPage - 1}, ${showArchived})" ${currentRoomsPage === 1 ? 'disabled' : ''}><i class="fas fa-chevron-left"></i></button>`;
            
            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= currentRoomsPage - 1 && i <= currentRoomsPage + 1)) {
                    html += `<button onclick="changeRoomsPage(${i}, ${showArchived})" ${i === currentRoomsPage ? 'class="active"' : ''}>${i}</button>`;
                } else if (i === currentRoomsPage - 2 || i === currentRoomsPage + 2) {
                    html += `<span>...</span>`;
                }
            }
            
            html += `<button onclick="changeRoomsPage(${currentRoomsPage + 1}, ${showArchived})" ${currentRoomsPage === totalPages ? 'disabled' : ''}><i class="fas fa-chevron-right"></i></button>`;
            
            paginationContainer.innerHTML = html;
        }

        function renderRoomTypesPagination(totalRoomTypes, showArchived) {
            const totalPages = Math.ceil(totalRoomTypes / roomTypesPerPage);
            const paginationContainer = document.getElementById('roomTypesPagination');
            
            if (totalPages <= 1) {
                paginationContainer.innerHTML = '';
                return;
            }
            
            let html = '';
            
            html += `<button onclick="changeRoomTypesPage(${currentRoomTypesPage - 1}, ${showArchived})" ${currentRoomTypesPage === 1 ? 'disabled' : ''}><i class="fas fa-chevron-left"></i></button>`;
            
            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= currentRoomTypesPage - 1 && i <= currentRoomTypesPage + 1)) {
                    html += `<button onclick="changeRoomTypesPage(${i}, ${showArchived})" ${i === currentRoomTypesPage ? 'class="active"' : ''}>${i}</button>`;
                } else if (i === currentRoomTypesPage - 2 || i === currentRoomTypesPage + 2) {
                    html += `<span>...</span>`;
                }
            }
            
            html += `<button onclick="changeRoomTypesPage(${currentRoomTypesPage + 1}, ${showArchived})" ${currentRoomTypesPage === totalPages ? 'disabled' : ''}><i class="fas fa-chevron-right"></i></button>`;
            
            paginationContainer.innerHTML = html;
        }

        function changeRoomsPage(page, showArchived) {
            currentRoomsPage = page;
            renderRoomsTable(showArchived);
        }

        function changeRoomTypesPage(page, showArchived) {
            currentRoomTypesPage = page;
            renderRoomTypesTable(showArchived);
        }

        function renderRoomsTable(showArchived) {
            const rooms = showArchived ? allArchivedRooms : allActiveRooms;
            toggleLabel.textContent = showArchived ? 'Archived' : 'Active';
            
            if (rooms.length === 0) {
                roomsBody.innerHTML = '<tr><td colspan="5" style="text-align: center; padding: 40px;"><i class="fas fa-door-closed" style="font-size: 48px; color: #ddd; margin-bottom: 10px; display: block;"></i>' + (showArchived ? 'No archived rooms' : 'No active rooms') + '</td></tr>';
                document.getElementById('roomsPagination').innerHTML = '';
                return;
            }

            const startIndex = (currentRoomsPage - 1) * roomsPerPage;
            const endIndex = startIndex + roomsPerPage;
            const paginatedRooms = rooms.slice(startIndex, endIndex);

            let html = '';
            paginatedRooms.forEach(room => {
                let actionBtn = '';
                
                if (showArchived) {
                    if (room.room_type_archived == 1) {
                        actionBtn = `<button type="button"class="restore-btn" disabled title="Room type is archived" style="opacity: 0.5; cursor: not-allowed;"><i class="fas fa-exclamation-triangle"></i> Room Type Archived</button>`;
                    } else {
                        actionBtn = `<form method="POST" action="add_rooms.php" style="display: inline;"><input type="hidden" name="action" value="archive_room"><input type="hidden" name="room_id" value="${room.room_id}"><input type="hidden" name="is_archived" value="0"><button type="submit" class="restore-btn"><i class="fas fa-undo"></i> Restore</button></form>`;
                    }
                } else {
                    if (room.status === 'maintenance') {
                        actionBtn = `<form method="POST" action="add_rooms.php" style="display: inline; margin-right: 5px;"><input type="hidden" name="action" value="maintenance"><input type="hidden" name="room_id" value="${room.room_id}"><input type="hidden" name="maintenance_status" value="available"><button type="submit" class="status-btn status-btn-available"><i class="fas fa-check"></i> Set Available</button></form>`;
                        actionBtn += `<form method="POST" action="add_rooms.php" style="display: inline;"><input type="hidden" name="action" value="archive_room"><input type="hidden" name="room_id" value="${room.room_id}"><input type="hidden" name="is_archived" value="1"><button type="submit" class="archive-btn"><i class="fas fa-archive"></i> Archive</button></form>`;
                    } else if (room.status === 'reserved' || room.status === 'occupied') {
                        actionBtn = `<button type="button" class="status-btn" disabled title="Cannot change status of reserved or occupied room"><i class="fas fa-lock"></i> ${room.status.charAt(0).toUpperCase() + room.status.slice(1)}</button>`;
                    } else {
                        actionBtn = `<form method="POST" action="add_rooms.php" style="display: inline; margin-right: 5px;"><input type="hidden" name="action" value="maintenance"><input type="hidden" name="room_id" value="${room.room_id}"><input type="hidden" name="maintenance_status" value="maintenance"><button type="submit" class="status-btn status-btn-maintenance"><i class="fas fa-tools"></i> Set Maintenance</button></form>`;
                        actionBtn += `<form method="POST" action="add_rooms.php" style="display: inline;"><input type="hidden" name="action" value="archive_room"><input type="hidden" name="room_id" value="${room.room_id}"><input type="hidden" name="is_archived" value="1"><button type="submit" class="archive-btn"><i class="fas fa-archive"></i> Archive</button></form>`;
                    }
                }
                
                html += `<tr>
                    <td><strong>${room.room_number}</strong></td>
                    <td>${room.type_name}</td>
                    <td>${room.floor}</td>
                    <td><span class="status ${room.status}">${room.status.charAt(0).toUpperCase() + room.status.slice(1)}</span></td>
                    <td>${actionBtn}</td>
                </tr>`;
            });

            roomsBody.innerHTML = html;
            renderRoomsPagination(rooms.length, showArchived);
        }

        function renderRoomTypesTable(showArchived) {
            const roomTypes = showArchived ? allArchivedRoomTypes : allActiveRoomTypes;
            toggleLabelTypes.textContent = showArchived ? 'Archived' : 'Active';
            
            if (roomTypes.length === 0) {
                roomTypesBody.innerHTML = '<tr><td colspan="5" style="text-align: center; padding: 40px;"><i class="fas fa-box" style="font-size: 48px; color: #ddd; margin-bottom: 10px; display: block;"></i>' + (showArchived ? 'No archived room types' : 'No active room types') + '</td></tr>';
                document.getElementById('roomTypesPagination').innerHTML = '';
                return;
            }

            const startIndex = (currentRoomTypesPage - 1) * roomTypesPerPage;
            const endIndex = startIndex + roomTypesPerPage;
            const paginatedRoomTypes = roomTypes.slice(startIndex, endIndex);

            let html = '';
            paginatedRoomTypes.forEach(type => {
                const price = parseFloat(type.base_price).toFixed(2);
                const pluralText = type.max_occupancy > 1 ? 's' : '';
                
                let actionBtn = '';
                if (showArchived) {
                    actionBtn = `<form method="POST" action="add_rooms.php" style="display: inline;"><input type="hidden" name="action" value="archive_room_type"><input type="hidden" name="room_type_id" value="${type.room_type_id}"><input type="hidden" name="is_archived" value="0"><button type="submit" class="restore-btn"><i class="fas fa-undo"></i> Restore</button></form>`;
                } else {
                    actionBtn = `<form method="POST" action="add_rooms.php" style="display: inline;"><input type="hidden" name="action" value="archive_room_type"><input type="hidden" name="room_type_id" value="${type.room_type_id}"><input type="hidden" name="is_archived" value="1"><button type="submit" class="archive-btn"><i class="fas fa-archive"></i> Archive</button></form>`;
                }
                
                html += `<tr>
                    <td><strong>${type.type_name}</strong></td>
                    <td>${type.max_occupancy} person${pluralText}</td>
                    <td>₱${price}</td>
                    <td>${type.description}</td>
                    <td>${actionBtn}</td>
                </tr>`;
            });

            roomTypesBody.innerHTML = html;
            renderRoomTypesPagination(roomTypes.length, showArchived);
        }

        renderRoomsTable(false);
        renderRoomTypesTable(false);
    </script>


</body>
</html>