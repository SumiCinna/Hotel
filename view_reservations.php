<?php
require_once 'config.php';
date_default_timezone_set('Asia/Manila');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header('Location: login.php');
    exit();
}

$db = new Database();
$conn = $db->getConnection();

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

$count_query = "SELECT COUNT(DISTINCT res.reservation_id) as count FROM reservations res JOIN payments p ON res.reservation_id = p.reservation_id WHERE p.payment_status = 'completed'";
$count_result = $conn->query($count_query);
$total_count = $count_result->fetch_assoc()['count'];
$total_pages = ceil($total_count / $per_page);

$reservations = $conn->query("SELECT res.reservation_id, u.full_name, u.email, u.phone, r.room_number, rt.type_name, res.check_in_date, res.check_out_date, res.total_amount, res.status, res.special_requests, res.created_at FROM reservations res JOIN users u ON res.user_id = u.user_id JOIN rooms r ON res.room_id = r.room_id JOIN room_types rt ON r.room_type_id = rt.room_type_id JOIN payments p ON res.reservation_id = p.reservation_id WHERE p.payment_status = 'completed' ORDER BY res.created_at DESC LIMIT $offset, $per_page");

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reservations - Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/view_reservations.css">
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
            <a href="view_reservations.php" class="menu-item active">
                <i class="fas fa-calendar-check"></i>
                <span>View Reservations</span>
            </a>
            <a href="room_status.php" class="menu-item">
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
                <h1>View Reservations</h1>
                <div class="breadcrumb">
                    <span>Home</span>
                    <i class="fas fa-chevron-right"></i>
                    <span>Reservations</span>
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
                <h3><i class="fas fa-calendar-check"></i> All Paid Reservations</h3>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Guest Name</th>
                                <th>Contact</th>
                                <th>Room</th>
                                <th>Type</th>
                                <th>Check-In</th>
                                <th>Check-Out</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Booked On</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($reservations && $reservations->num_rows > 0): ?>
                                <?php while ($res = $reservations->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $res['reservation_id']; ?></td>
                                    <td><?php echo htmlspecialchars($res['full_name']); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($res['phone']); ?><br>
                                        <small style="color: #64748b;"><?php echo htmlspecialchars($res['email']); ?></small>
                                    </td>
                                    <td><?php echo htmlspecialchars($res['room_number']); ?></td>
                                    <td><?php echo htmlspecialchars($res['type_name']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($res['check_in_date'])); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($res['check_out_date'])); ?></td>
                                    <td><strong style="color: #2563eb;">₱<?php echo number_format($res['total_amount'], 2); ?></strong></td>
                                    <td><span class="status <?php echo $res['status']; ?>"><?php echo ucfirst(str_replace('_', ' ', $res['status'])); ?></span></td>
                                    <td><?php echo date('M d, Y', strtotime($res['created_at'])); ?></td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" style="text-align: center; padding: 20px; color: #666;">No paid reservations found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo ($page - 1); ?>">
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
                            <a href="?page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo ($page + 1); ?>">
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