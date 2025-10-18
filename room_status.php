<?php
require_once 'config.php';
date_default_timezone_set('Asia/Manila');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header('Location: login.php');
    exit();
}

$db = new Database();
$conn = $db->getConnection();

$page_occupancy = isset($_GET['page_occupancy']) ? max(1, intval($_GET['page_occupancy'])) : 1;
$page_rooms = isset($_GET['page_rooms']) ? max(1, intval($_GET['page_rooms'])) : 1;
$per_page = 10;
$offset_occupancy = ($page_occupancy - 1) * $per_page;
$offset_rooms = ($page_rooms - 1) * $per_page;

$count_occupancy = $conn->query("SELECT COUNT(*) as count FROM reservations res WHERE res.status = 'checked_in' OR (res.status = 'confirmed' AND EXISTS (SELECT 1 FROM rooms r WHERE r.room_id = res.room_id AND r.status = 'reserved'))")->fetch_assoc()['count'];
$total_pages_occupancy = ceil($count_occupancy / $per_page);

$count_rooms = $conn->query("SELECT COUNT(*) as count FROM rooms")->fetch_assoc()['count'];
$total_pages_rooms = ceil($count_rooms / $per_page);

$rooms = $conn->query("SELECT r.room_id, r.room_number, rt.type_name, rt.base_price, r.floor, r.status FROM rooms r JOIN room_types rt ON r.room_type_id = rt.room_type_id ORDER BY r.room_number LIMIT $offset_rooms, $per_page");

$room_stats = $conn->query("SELECT (SELECT COUNT(*) FROM rooms WHERE status = 'available') as available, (SELECT COUNT(*) FROM rooms WHERE status = 'occupied') as occupied, (SELECT COUNT(*) FROM rooms WHERE status = 'maintenance') as maintenance, (SELECT COUNT(*) FROM rooms WHERE status = 'reserved') as reserved")->fetch_assoc();

$current_occupancy = $conn->query("SELECT res.reservation_id, r.room_number, rt.type_name, u.full_name, u.phone, res.check_in_date, res.check_out_date FROM reservations res JOIN rooms r ON res.room_id = r.room_id JOIN room_types rt ON r.room_type_id = rt.room_type_id JOIN users u ON res.user_id = u.user_id WHERE res.status = 'checked_in' OR (res.status = 'confirmed' AND r.status = 'reserved') ORDER BY r.room_number LIMIT $offset_occupancy, $per_page");

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Status - Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/room_status.css">
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 30px;
            padding: 20px 0;
        }
        
        .pagination a, .pagination span {
            padding: 10px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            text-decoration: none;
            color: #334155;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .pagination a:hover {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
            transform: translateY(-2px);
        }
        
        .pagination .current {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
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
                <h2>LuxeStay</h2>
            </div>
            <div class="user-info">
                <h3><?php echo htmlspecialchars($_SESSION['full_name']); ?></h3>
                <p><i class="fas fa-user-tie"></i> Manager</p>
            </div>
        </div>
        
        <div class="sidebar-menu">
            <a href="manager_dashboard.php" class="menu-item">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            <a href="view_reports.php" class="menu-item">
                <i class="fas fa-file-alt"></i>
                <span>View Reports</span>
            </a>
            <a href="view_reservations.php" class="menu-item">
                <i class="fas fa-calendar-check"></i>
                <span>View Reservations</span>
            </a>
            <a href="room_status.php" class="menu-item active">
                <i class="fas fa-door-open"></i>
                <span>Room Status</span>
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
                <h1>Room Status</h1>
                <div class="breadcrumb">
                    <span>Home</span>
                    <i class="fas fa-chevron-right"></i>
                    <span>Room Status</span>
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
            <div class="stats-grid">
                <div class="stat-card">
                    <h3><?php echo $room_stats['available']; ?></h3>
                    <p>Available Rooms</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $room_stats['occupied']; ?></h3>
                    <p>Occupied Rooms</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $room_stats['reserved']; ?></h3>
                    <p>Reserved Rooms</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $room_stats['maintenance']; ?></h3>
                    <p>Under Maintenance</p>
                </div>
            </div>
            
            <div class="section">
                <h3><i class="fas fa-users"></i> Current Occupancy</h3>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Reservation ID</th>
                                <th>Room</th>
                                <th>Type</th>
                                <th>Guest Name</th>
                                <th>Phone</th>
                                <th>Check-In</th>
                                <th>Check-Out</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($current_occupancy && $current_occupancy->num_rows > 0): ?>
                                <?php while ($row = $current_occupancy->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['reservation_id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['room_number']); ?></td>
                                    <td><?php echo htmlspecialchars($row['type_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($row['check_in_date'])); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($row['check_out_date'])); ?></td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 20px; color: #666;">No occupied or reserved rooms</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if ($total_pages_occupancy > 1): ?>
                <div class="pagination">
                    <?php if ($page_occupancy > 1): ?>
                        <a href="?page_occupancy=<?php echo ($page_occupancy - 1); ?>&page_rooms=<?php echo $page_rooms; ?>">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                    <?php else: ?>
                        <span class="disabled">
                            <i class="fas fa-chevron-left"></i> Previous
                        </span>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $total_pages_occupancy; $i++): ?>
                        <?php if ($i == $page_occupancy): ?>
                            <span class="current"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="?page_occupancy=<?php echo $i; ?>&page_rooms=<?php echo $page_rooms; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if ($page_occupancy < $total_pages_occupancy): ?>
                        <a href="?page_occupancy=<?php echo ($page_occupancy + 1); ?>&page_rooms=<?php echo $page_rooms; ?>">
                            Next <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php else: ?>
                        <span class="disabled">
                            Next <i class="fas fa-chevron-right"></i>
                        </span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="section">
                <h3><i class="fas fa-door-open"></i> All Rooms Status</h3>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Room ID</th>
                                <th>Room Number</th>
                                <th>Type</th>
                                <th>Floor</th>
                                <th>Price/Night</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($room = $rooms->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $room['room_id']; ?></td>
                                <td><?php echo htmlspecialchars($room['room_number']); ?></td>
                                <td><?php echo htmlspecialchars($room['type_name']); ?></td>
                                <td><?php echo $room['floor']; ?></td>
                                <td><strong style="color: #2563eb;">₱<?php echo number_format($room['base_price'], 2); ?></strong></td>
                                <td><span class="status <?php echo $room['status']; ?>"><?php echo ucfirst($room['status']); ?></span></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if ($total_pages_rooms > 1): ?>
                <div class="pagination">
                    <?php if ($page_rooms > 1): ?>
                        <a href="?page_occupancy=<?php echo $page_occupancy; ?>&page_rooms=<?php echo ($page_rooms - 1); ?>">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                    <?php else: ?>
                        <span class="disabled">
                            <i class="fas fa-chevron-left"></i> Previous
                        </span>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $total_pages_rooms; $i++): ?>
                        <?php if ($i == $page_rooms): ?>
                            <span class="current"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="?page_occupancy=<?php echo $page_occupancy; ?>&page_rooms=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if ($page_rooms < $total_pages_rooms): ?>
                        <a href="?page_occupancy=<?php echo $page_occupancy; ?>&page_rooms=<?php echo ($page_rooms + 1); ?>">
                            Next <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php else: ?>
                        <span class="disabled">
                            Next <i class="fas fa-chevron-right"></i>
                        </span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>