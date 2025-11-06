<?php
require_once 'config.php';
date_default_timezone_set('Asia/Manila');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header('Location: login.php');
    exit();
}

$db = new Database();
$conn = $db->getConnection();

$today_revenue = 0;
$month_revenue = 0;


$daily_report_result = $conn->query("SELECT * FROM vw_daily_revenue_report WHERE date = CURDATE()");
if ($daily_report_result && $row = $daily_report_result->fetch_assoc()) {
    $today_revenue = $row['revenue'] ?? 0;
}


$current_month = date('Y-m');
$monthly_report_result = $conn->query("SELECT * FROM vw_monthly_revenue_report WHERE month = '$current_month'");
if ($monthly_report_result && $row = $monthly_report_result->fetch_assoc()) {
    $month_revenue = $row['revenue'] ?? 0;
}


$monthly_report = $conn->query("SELECT * FROM vw_monthly_revenue_report ORDER BY month DESC LIMIT 12");

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard - Hotel Reservation System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/manager_dashboard.css">
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
            <a href="manager_dashboard.php" class="menu-item active">
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
                <h1>Manager Dashboard</h1>
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
                <h2><i class="fas fa-hand-wave"></i> Welcome Back, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h2>
                <p>Generate Reports & View Transaction Base</p>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-peso-sign"></i>
                        </div>
                        <div class="stat-value">
                            <h3>₱<?php echo number_format($today_revenue, 2); ?></h3>
                            <p>Today's Revenue</p>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-value">
                            <h3>₱<?php echo number_format($month_revenue, 2); ?></h3>
                            <p>This Month's Revenue</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <div class="section-header">
                    <h3><i class="fas fa-chart-bar"></i> Monthly Revenue Report</h3>
                    <a href="view_reports.php" class="btn btn-small">
                        <i class="fas fa-eye"></i>
                        View Full Report
                    </a>
                </div>
                <?php if ($monthly_report && $monthly_report->num_rows > 0): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-calendar"></i> Month</th>
                                <th><i class="fas fa-list"></i> Total Bookings</th>
                                <th><i class="fas fa-peso-sign"></i> Total Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($report = $monthly_report->fetch_assoc()): ?>
                            <tr>
                                <td><strong><?php echo date('F Y', strtotime($report['month'] . '-01')); ?></strong></td>
                                <td><?php echo $report['bookings']; ?> bookings</td>
                                <td><strong style="color: #2563eb;">₱<?php echo number_format($report['revenue'], 2); ?></strong></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-chart-bar"></i>
                    <p>No revenue data available</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>