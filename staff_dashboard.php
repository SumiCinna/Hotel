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

if (isset($_POST['approve_reservation'])) {
    $reservation_id = intval($_POST['reservation_id']);
    
    try {
        $stmt = $conn->prepare("CALL sp_approve_reservation(?, @success, @message)");
        $stmt->bind_param("i", $reservation_id);
        $stmt->execute();
        $stmt->close();
        
        $result = $conn->query("SELECT @success as success, @message as message");
        $output = $result->fetch_assoc();
        
        if ($output['success']) {
            header('Location: staff_dashboard.php?approval_success=1');
        } else {
            header('Location: staff_dashboard.php?approval_error=1&msg=' . urlencode($output['message']));
        }
        exit();

    } catch (Exception $e) {
        header('Location: staff_dashboard.php?approval_error=1');
        exit();
    }
}

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$per_page = 5;
$offset = ($page - 1) * $per_page;

$total_pending_row = $conn->query("SELECT * FROM vw_staff_total_pending_count")->fetch_assoc();
$total_pending = $total_pending_row['count'];
$total_pages = ceil($total_pending / $per_page);

$latest_reservations = $conn->query("SELECT * FROM vw_staff_latest_reservations LIMIT 5");

$pending_reservations = $conn->query("SELECT * FROM vw_staff_pending_reservations LIMIT $offset, $per_page");

$pending_approval_reservations = $conn->query("SELECT * FROM vw_pending_reservations LIMIT 10");

$available_rooms = $conn->query("SELECT * FROM vw_staff_available_rooms LIMIT 10");

$stats = $conn->query("SELECT * FROM vw_staff_stats")->fetch_assoc();

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - Hotel Reservation System</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/staff_dashboard.css">
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
            cursor: pointer;
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
        
        .status.pending_approval {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
        }
        
        .btn-approve {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-approve:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6);
            animation: fadeIn 0.3s;
        }
        
        .modal.show {
            display: flex !important;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background-color: #fff;
            padding: 0;
            border-radius: 12px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s;
        }
        
        .modal-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 20px;
            border-radius: 12px 12px 0 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .modal-header i {
            font-size: 24px;
        }
        
        .modal-header h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }
        
        .modal-body {
            padding: 30px;
        }
        
        .modal-body p {
            font-size: 16px;
            color: #334155;
            margin-bottom: 20px;
        }
        
        .reservation-details {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }
        
        .reservation-details p {
            margin: 8px 0;
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }
        
        .reservation-details strong {
            color: #64748b;
        }
        
        .reservation-details span {
            color: #1e293b;
            font-weight: 600;
        }
        
        .modal-footer {
            padding: 20px 30px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            border-top: 1px solid #e2e8f0;
        }
        
        .modal-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .modal-btn-cancel {
            background: #e2e8f0;
            color: #475569;
        }
        
        .modal-btn-cancel:hover {
            background: #cbd5e1;
        }
        
        .modal-btn-confirm {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        
        .modal-btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
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
            <?php if (isset($_GET['approval_success'])): ?>
            <div class="success" style="margin-bottom: 20px; padding: 15px; background: #d1fae5; color: #065f46; border-radius: 8px;">
                <i class="fas fa-check-circle"></i> Reservation approved successfully! Payment has been recorded.
            </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['approval_error'])): ?>
            <div class="error" style="margin-bottom: 20px; padding: 15px; background: #fee2e2; color: #991b1b; border-radius: 8px;">
                <i class="fas fa-exclamation-circle"></i> Failed to approve reservation. Please try again.
            </div>
            <?php endif; ?>
            
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
                    <h3 class="playfair"><i class="fas fa-hourglass-half"></i> Pending Approval</h3>
                </div>
                <?php if ($pending_approval_reservations && $pending_approval_reservations->num_rows > 0): ?>
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
                                <th><i class="fas fa-credit-card"></i> Paid</th>
                                <th><i class="fas fa-cog"></i> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($res = $pending_approval_reservations->fetch_assoc()): ?>
                            <tr>
                                <td><strong><?php echo $res['reservation_id']; ?></strong></td>
                                <td><?php echo htmlspecialchars($res['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($res['phone']); ?><br><small style="color: #64748b;"><?php echo htmlspecialchars($res['email']); ?></small></td>
                                <td><?php echo htmlspecialchars($res['room_number']); ?></td>
                                <td><?php echo htmlspecialchars($res['type_name']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($res['check_in_date'])); ?></td>
                                <td><?php echo date('M d, Y', strtotime($res['check_out_date'])); ?></td>
                                <td>₱<?php echo number_format($res['total_amount'], 2); ?></td>
                                <td>₱<?php echo number_format($res['amount'], 2); ?></td>
                                <td>
                                    <button type="button" class="btn-approve" onclick="openApproveModal(<?php echo $res['reservation_id']; ?>, '<?php echo htmlspecialchars($res['full_name']); ?>', '<?php echo htmlspecialchars($res['room_number']); ?>', '<?php echo htmlspecialchars($res['type_name']); ?>', '<?php echo date('M d, Y', strtotime($res['check_in_date'])); ?>', '<?php echo date('M d, Y', strtotime($res['check_out_date'])); ?>', '<?php echo number_format($res['total_amount'], 2); ?>')">
                                        <i class="fas fa-check"></i>
                                        Approve
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-check-circle"></i>
                    <p>No reservations pending approval</p>
                </div>
                <?php endif; ?>
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
            
            <div class="section" id="pendingSection">
                <div class="section-header">
                    <h3 class="playfair"><i class="fas fa-clock"></i> Pending & Confirmed Reservations</h3>
                    <a href="manage_bookings.php" class="btn btn-small">
                        <i class="fas fa-eye"></i>
                        View All
                    </a>
                </div>
                <div id="pendingTableContainer">
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
                            <a onclick="loadPage(1); return false;"><i class="fas fa-angle-double-left"></i></a>
                            <a onclick="loadPage(<?php echo $page - 1; ?>); return false;"><i class="fas fa-angle-left"></i></a>
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
                                <a onclick="loadPage(<?php echo $i; ?>); return false;"><?php echo $i; ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                        
                        <?php if ($page < $total_pages): ?>
                            <a onclick="loadPage(<?php echo $page + 1; ?>); return false;"><i class="fas fa-angle-right"></i></a>
                            <a onclick="loadPage(<?php echo $total_pages; ?>); return false;"><i class="fas fa-angle-double-right"></i></a>
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
        </div</div>

    <div id="approveModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fas fa-check-circle"></i>
                <h2>Approve Reservation</h2>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to approve this reservation?</p>
                <div class="reservation-details" id="modalReservationDetails">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-cancel" onclick="closeApproveModal()">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <form method="POST" style="display: inline;" id="approveForm">
                    <input type="hidden" name="reservation_id" id="modalReservationId">
                    <button type="submit" name="approve_reservation" class="modal-btn modal-btn-confirm">
                        <i class="fas fa-check"></i>
                        Yes, Approve
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openApproveModal(id, guest, room, type, checkIn, checkOut, amount) {
            document.getElementById('modalReservationId').value = id;
            document.getElementById('modalReservationDetails').innerHTML = `
                <p><strong>Reservation ID:</strong> <span>#${id}</span></p>
                <p><strong>Guest:</strong> <span>${guest}</span></p>
                <p><strong>Room:</strong> <span>${room}</span></p>
                <p><strong>Type:</strong> <span>${type}</span></p>
                <p><strong>Check-In:</strong> <span>${checkIn}</span></p>
                <p><strong>Check-Out:</strong> <span>${checkOut}</span></p>
                <p><strong>Amount:</strong> <span>₱${amount}</span></p>
            `;
            document.getElementById('approveModal').classList.add('show');
        }

        function closeApproveModal() {
            document.getElementById('approveModal').classList.remove('show');
        }

        window.onclick = function(event) {
            const modal = document.getElementById('approveModal');
            if (event.target == modal) {
                closeApproveModal();
            }
        }

        function loadPage(page) {
            const container = document.getElementById('pendingTableContainer');
            const section = document.getElementById('pendingSection');
            
            fetch(`get_pending_reservations.php?page=${page}`)
                .then(response => response.text())
                .then(html => {
                    container.innerHTML = html;
                    section.scrollIntoView({ behavior: 'smooth', block: 'start' });
                })
                .catch(error => {
                    console.error('Error loading page:', error);
                });
        }
    </script>
</body>
</html>