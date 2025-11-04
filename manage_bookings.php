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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $reservation_id = $_POST['reservation_id'];
    $new_status = $_POST['status'];
    $room_id = $_POST['room_id'];
    
    $update_stmt = $conn->prepare("CALL sp_update_reservation_status(?, ?)");
    $update_stmt->bind_param("is", $reservation_id, $new_status);
    $update_stmt->execute();
    $update_stmt->close();
    
    if ($new_status === 'checked_in') {
        $room_update = $conn->prepare("CALL sp_update_room_status(?, 'occupied')");
        $room_update->bind_param("i", $room_id);
        $room_update->execute();
        $room_update->close();
    } elseif ($new_status === 'checked_out' || $new_status === 'cancelled') {
        $room_update = $conn->prepare("CALL sp_update_room_status(?, 'available')");
        $room_update->bind_param("i", $room_id);
        $room_update->execute();
        $room_update->close();
    }
    
    $_SESSION['success'] = "Reservation status updated successfully!";
    header("Location: manage_bookings.php");
    exit();
}

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

$count_stmt = $conn->prepare("CALL sp_get_reservations_count(?, ?)");
$count_stmt->bind_param("ss", $filter, $search);
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_count = $count_result->fetch_assoc()['count'];
$total_pages = ceil($total_count / $per_page);
$count_stmt->close();

$stmt = $conn->prepare("CALL sp_get_reservations(?, ?, ?, ?)");
$stmt->bind_param("ssii", $filter, $search, $offset, $per_page);
$stmt->execute();
$reservations = $stmt->get_result();

if (!$reservations) {
    die("Query Error: " . $conn->error);
}

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings - Hotel Reservation System</title>
    <link rel="stylesheet" href="css/manage_bookings.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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
                <h1 class="playfair">Manage Bookings</h1>
                <div class="breadcrumb">
                    <span>Home</span>
                    <i class="fas fa-chevron-right"></i>
                    <span>Manage Bookings</span>
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
            
            <div class="section">
                <div class="section-header">
                    <h3 class="playfair"><i class="fas fa-calendar-check"></i> All Reservations</h3>
                </div>
                
                <form method="GET" action="manage_bookings.php">
                    <div class="filter-bar">
                        <a href="manage_bookings.php?filter=all" class="filter-btn <?php echo $filter === 'all' ? 'active' : ''; ?>">
                            <i class="fas fa-list"></i> All
                        </a>
                        <a href="manage_bookings.php?filter=pending" class="filter-btn <?php echo $filter === 'pending' ? 'active' : ''; ?>">
                            <i class="fas fa-clock"></i> Pending
                        </a>
                        <a href="manage_bookings.php?filter=confirmed" class="filter-btn <?php echo $filter === 'confirmed' ? 'active' : ''; ?>">
                            <i class="fas fa-check-circle"></i> Confirmed
                        </a>
                        <a href="manage_bookings.php?filter=checked_in" class="filter-btn <?php echo $filter === 'checked_in' ? 'active' : ''; ?>">
                            <i class="fas fa-sign-in-alt"></i> Checked In
                        </a>
                        <a href="manage_bookings.php?filter=checked_out" class="filter-btn <?php echo $filter === 'checked_out' ? 'active' : ''; ?>">
                            <i class="fas fa-sign-out-alt"></i> Checked Out
                        </a>
                        <a href="manage_bookings.php?filter=cancelled" class="filter-btn <?php echo $filter === 'cancelled' ? 'active' : ''; ?>">
                            <i class="fas fa-times-circle"></i> Cancelled
                        </a>
                        <div class="search-box">
                            <input type="text" name="search" placeholder="Search by name, phone, room..." value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                        <button type="submit" class="btn btn-small">
                            <i class="fas fa-search"></i>
                            Search
                        </button>
                    </div>
                </form>
                
                <?php if ($reservations && $reservations->num_rows > 0): ?>
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
                            <?php while ($res = $reservations->fetch_assoc()): ?>
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
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="reservation_id" value="<?php echo $res['reservation_id']; ?>">
                                        <input type="hidden" name="room_id" value="<?php echo $res['room_id']; ?>">
                                        <input type="hidden" name="update_status" value="1">
                                        <select name="status" class="status-select" onchange="this.form.submit()">
                                            <option value="pending" <?php echo $res['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="confirmed" <?php echo $res['status'] === 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                            <option value="checked_in" <?php echo $res['status'] === 'checked_in' ? 'selected' : ''; ?>>Checked In</option>
                                            <option value="checked_out" <?php echo $res['status'] === 'checked_out' ? 'selected' : ''; ?>>Checked Out</option>
                                            <option value="cancelled" <?php echo $res['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo ($page - 1); ?>&filter=<?php echo $filter; ?>&search=<?php echo urlencode($search); ?>">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                    <?php else: ?>
                        <span class="disabled">
                            <i class="fas fa-chevron-left"></i> Previous
                        </span>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <?php if ($i == $page): ?>
                            <span class="current"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="?page=<?php echo $i; ?>&filter=<?php echo $filter; ?>&search=<?php echo urlencode($search); ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo ($page + 1); ?>&filter=<?php echo $filter; ?>&search=<?php echo urlencode($search); ?>">
                            Next <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php else: ?>
                        <span class="disabled">
                            Next <i class="fas fa-chevron-right"></i>
                        </span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <p>No reservations found</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>