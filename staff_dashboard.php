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

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$per_page = 5;
$offset = ($page - 1) * $per_page;

$total_pending_row = $conn->query("SELECT * FROM vw_staff_total_pending_count")->fetch_assoc();
$total_pending = $total_pending_row['count'];
$total_pages = ceil($total_pending / $per_page);

$latest_reservations = $conn->query("SELECT * FROM vw_staff_latest_reservations LIMIT 5");

$pending_reservations = $conn->query("SELECT * FROM vw_staff_pending_reservations LIMIT $offset, $per_page");

$available_rooms = $conn->query("SELECT * FROM vw_staff_available_rooms LIMIT 10");

$stats = $conn->query("SELECT * FROM vw_staff_stats")->fetch_assoc();

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="css/staff_dashboard.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - Hotel Reservation System</title>
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
        
        .special-request-cell {
            max-width: 200px;
        }
        
        .special-request-text {
            color: #64748b;
            font-size: 13px;
            font-style: italic;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .no-request {
            color: #cbd5e1;
            font-size: 12px;
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
                <h1 class="playfair">Staff Dashboard</h1>
                <div class="breadcrumb">
                    <span>Home</span>
                    <i class="fas fa-chevron-right"></i>
                    <span>Dashboard</span>
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
            <div class="welcome-card">
                <h2 class="playfair"><i class="fas fa-hand-wave"></i> Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h2>
                <p>Manage Reservations of Rooms and Transactions</p>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-door-open"></i>
                        </div>
                        <div class="stat-value">
                            <h3><?php echo $stats['available_rooms']; ?></h3>
                            <p>Available Rooms</p>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-bed"></i>
                        </div>
                        <div class="stat-value">
                            <h3><?php echo $stats['occupied_rooms']; ?></h3>
                            <p>Occupied Rooms</p>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-value">
                            <h3><?php echo $stats['pending_reservations']; ?></h3>
                            <p>Pending Reservations</p>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <div class="stat-value">
                            <h3><?php echo $stats['today_checkins']; ?></h3>
                            <p>Today's Check-Ins</p>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-sign-out-alt"></i>
                        </div>
                        <div class="stat-value">
                            <h3><?php echo $stats['today_checkouts']; ?></h3>
                            <p>Today's Check-Outs</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <div class="section-header">
                    <h3 class="playfair"><i class="fas fa-history"></i> Latest Reservations</h3>
                    <a href="manage_bookings.php" class="btn btn-small">
                        <i class="fas fa-eye"></i>
                        View All
                    </a>
                </div>
                <?php if ($latest_reservations && $latest_reservations->num_rows > 0): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag"></i> ID</th>
                                <th><i class="fas fa-user"></i> Guest</th>
                                <th><i class="fas fa-address-book"></i> Contact</th>
                                <th><i class="fas fa-door-closed"></i> Room</th>
                                <th><i class="fas fa-bed"></i> Type</th>
                                <th><i class="fas fa-calendar-check"></i> Check-In</th>
                                <th><i class="fas fa-calendar-times"></i> Check-Out</th>
                                <th><i class="fas fa-peso-sign"></i> Amount</th>
                                <th><i class="fas fa-comment-dots"></i> Special Requests</th>
                                <th><i class="fas fa-info-circle"></i> Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($res = $latest_reservations->fetch_assoc()): ?>
                            <tr>
                                <td><strong><?php echo $res['reservation_id']; ?></strong></td>
                                <td><?php echo htmlspecialchars($res['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($res['phone']); ?><br><small style="color: #64748b;"><?php echo htmlspecialchars($res['email'] ?? 'N/A'); ?></small></td>
                                <td><?php echo htmlspecialchars($res['room_number']); ?></td>
                                <td><?php echo htmlspecialchars($res['type_name']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($res['check_in_date'])); ?></td>
                                <td><?php echo date('M d, Y', strtotime($res['check_out_date'])); ?></td>
                                <td>₱<?php echo number_format($res['total_amount'], 2); ?></td>
                                <td class="special-request-cell">
                                    <?php if (!empty($res['special_requests'])): ?>
                                        <div class="special-request-text" title="<?php echo htmlspecialchars($res['special_requests']); ?>">
                                            <?php echo htmlspecialchars($res['special_requests']); ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="no-request">No special requests</span>
                                    <?php endif; ?>
                                </td>
                                <td><span class="status <?php echo $res['status']; ?>"><?php echo ucfirst(str_replace('_', ' ', $res['status'])); ?></span></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <p>No reservations found</p>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="section">
                <div class="section-header">
                    <h3 class="playfair"><i class="fas fa-clock"></i> Pending & Confirmed Reservations</h3>
                    <a href="manage_bookings.php" class="btn btn-small">
                        <i class="fas fa-eye"></i>
                        View All
                    </a>
                </div>
                <?php if ($pending_reservations && $pending_reservations->num_rows > 0): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag"></i> ID</th>
                                <th><i class="fas fa-user"></i> Guest</th>
                                <th><i class="fas fa-address-book"></i> Contact</th>
                                <th><i class="fas fa-door-closed"></i> Room</th>
                                <th><i class="fas fa-bed"></i> Type</th>
                                <th><i class="fas fa-calendar-check"></i> Check-In</th>
                                <th><i class="fas fa-calendar-times"></i> Check-Out</th>
                                <th><i class="fas fa-peso-sign"></i> Amount</th>
                                <th><i class="fas fa-comment-dots"></i> Special Requests</th>
                                <th><i class="fas fa-info-circle"></i> Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($res = $pending_reservations->fetch_assoc()): ?>
                            <tr>
                                <td><strong><?php echo $res['reservation_id']; ?></strong></td>
                                <td><?php echo htmlspecialchars($res['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($res['phone']); ?><br><small style="color: #64748b;"><?php echo htmlspecialchars($res['email']); ?></small></td>
                                <td><?php echo htmlspecialchars($res['room_number']); ?></td>
                                <td><?php echo htmlspecialchars($res['type_name']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($res['check_in_date'])); ?></td>
                                <td><?php echo date('M d, Y', strtotime($res['check_out_date'])); ?></td>
                                <td>₱<?php echo number_format($res['total_amount'], 2); ?></td>
                                <td class="special-request-cell">
                                    <?php if (!empty($res['special_requests'])): ?>
                                        <div class="special-request-text" title="<?php echo htmlspecialchars($res['special_requests']); ?>">
                                            <?php echo htmlspecialchars($res['special_requests']); ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="no-request">No special requests</span>
                                    <?php endif; ?>
                                </td>
                                <td><span class="status <?php echo $res['status']; ?>"><?php echo ucfirst(str_replace('_', ' ', $res['status'])); ?></span></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=1"><i class="fas fa-angle-double-left"></i></a>
                        <a href="?page=<?php echo $page - 1; ?>"><i class="fas fa-angle-left"></i></a>
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
                            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>"><i class="fas fa-angle-right"></i></a>
                        <a href="?page=<?php echo $total_pages; ?>"><i class="fas fa-angle-double-right"></i></a>
                    <?php else: ?>
                        <span class="disabled"><i class="fas fa-angle-right"></i></span>
                        <span class="disabled"><i class="fas fa-angle-double-right"></i></span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-calendar-check"></i>
                    <p>No pending or confirmed reservations</p>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="section">
                <div class="section-header">
                    <h3 class="playfair"><i class="fas fa-door-open"></i> Available Rooms</h3>
                    <a href="staff_rooms.php" class="btn btn-small">
                        <i class="fas fa-th-large"></i>
                        All Rooms
                    </a>
                </div>
                <?php if ($available_rooms && $available_rooms->num_rows > 0): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-door-closed"></i> Room Number</th>
                                <th><i class="fas fa-bed"></i> Type</th>
                                <th><i class="fas fa-building"></i> Floor</th>
                                <th><i class="fas fa-peso-sign"></i> Price/Night</th>
                                <th><i class="fas fa-toggle-on"></i> Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($room = $available_rooms->fetch_assoc()): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($room['room_number']); ?></strong></td>
                                <td><?php echo htmlspecialchars($room['type_name']); ?></td>
                                <td><?php echo $room['floor']; ?></td>
                                <td>₱<?php echo number_format($room['base_price'], 2); ?></td>
                                <td><span class="status <?php echo $room['status']; ?>"><?php echo ucfirst($room['status']); ?></span></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-door-closed"></i>
                    <p>No available rooms at the moment</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>