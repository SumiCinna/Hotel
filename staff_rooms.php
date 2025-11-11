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

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

$view_name = 'vw_staff_rooms_all';
if ($filter === 'available') {
    $view_name = 'vw_staff_rooms_available';
} elseif ($filter === 'occupied') {
    $view_name = 'vw_staff_rooms_occupied';
} elseif ($filter === 'maintenance') {
    $view_name = 'vw_staff_rooms_maintenance';
}

$total_rooms_row = $conn->query("SELECT COUNT(*) as count FROM $view_name")->fetch_assoc();
$total_rooms = $total_rooms_row['count'];
$total_pages = ceil($total_rooms / $per_page);

$rooms = $conn->query("SELECT * FROM $view_name LIMIT $offset, $per_page");

if (!$rooms) {
    die("Query Error: " . $conn->error);
}

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="css/staff_rooms.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Management - Hotel Reservation System</title>
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
        
        .pagination a, .pagination span {
            padding: 8px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            text-decoration: none;
            color: #334155;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .pagination a:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            border-color: #667eea;
            transform: translateY(-2px);
        }
        
        .pagination .current {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            border-color: #667eea;
        }
        
        .pagination .disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
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
                <h1 class="playfair">Room Management</h1>
                <div class="breadcrumb">
                    <span>Home</span>
                    <i class="fas fa-chevron-right"></i>
                    <span>Room Management</span>
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
            <div class="section">
                <div class="section-header">
                    <h3 class="playfair"><i class="fas fa-door-open"></i> All Rooms</h3>
                </div>
                
                <div class="filter-bar">
                    <a href="staff_rooms.php?filter=all" class="filter-btn <?php echo $filter === 'all' ? 'active' : ''; ?>">
                        <i class="fas fa-list"></i> All Rooms
                    </a>
                    <a href="staff_rooms.php?filter=available" class="filter-btn <?php echo $filter === 'available' ? 'active' : ''; ?>">
                        <i class="fas fa-door-open"></i> Available
                    </a>
                    <a href="staff_rooms.php?filter=occupied" class="filter-btn <?php echo $filter === 'occupied' ? 'active' : ''; ?>">
                        <i class="fas fa-bed"></i> Occupied
                    </a>
                    <a href="staff_rooms.php?filter=maintenance" class="filter-btn <?php echo $filter === 'maintenance' ? 'active' : ''; ?>">
                        <i class="fas fa-tools"></i> Maintenance
                    </a>
                </div>
                
                <?php if ($rooms && $rooms->num_rows > 0): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-door-closed"></i> Room Number</th>
                                <th><i class="fas fa-bed"></i> Type</th>
                                <th><i class="fas fa-building"></i> Floor</th>
                                <th><i class="fas fa-users"></i> Occupancy</th>
                                <th><i class="fas fa-peso-sign"></i> Price/Night</th>
                                <th><i class="fas fa-toggle-on"></i> Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($room = $rooms->fetch_assoc()): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($room['room_number']); ?></strong></td>
                                <td><?php echo htmlspecialchars($room['type_name']); ?></td>
                                <td><?php echo $room['floor']; ?></td>
                                <td><?php echo $room['max_occupancy']; ?> Guests</td>
                                <td>₱<?php echo number_format($room['base_price'], 2); ?></td>
                                <td><span class="status <?php echo $room['status']; ?>"><?php echo ucfirst($room['status']); ?></span></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?filter=<?php echo $filter; ?>&page=1"><i class="fas fa-angle-double-left"></i></a>
                        <a href="?filter=<?php echo $filter; ?>&page=<?php echo $page - 1; ?>"><i class="fas fa-angle-left"></i></a>
                    <?php else: ?>
                        <span class="disabled"><i class="fas fa-angle-double-left"></i></span>
                        <span class="disabled"><i class="fas fa-angle-left"></i></span>
                    <?php endif; ?>
                    
                    <?php
                    $start = max(1, $page - 2);
                    $end = min($total_pages, $page + 2);
                    
                    for ($i = $start; $i <= $end; $i++):
                    ?>
                        <?php if ($i == $page): ?>
                            <span class="current"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="?filter=<?php echo $filter; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                        <a href="?filter=<?php echo $filter; ?>&page=<?php echo $page + 1; ?>"><i class="fas fa-angle-right"></i></a>
                        <a href="?filter=<?php echo $filter; ?>&page=<?php echo $total_pages; ?>"><i class="fas fa-angle-double-right"></i></a>
                    <?php else: ?>
                        <span class="disabled"><i class="fas fa-angle-right"></i></span>
                        <span class="disabled"><i class="fas fa-angle-double-right"></i></span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-door-closed"></i>
                    <p>No rooms found</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>