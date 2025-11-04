<?php
require_once 'config.php';
date_default_timezone_set('Asia/Manila');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$db = new Database();
$conn = $db->getConnection();

$stats = null;
if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager') {
    $result = $conn->query("SELECT * FROM vw_dashboard_stats");
    if ($result) {
        $stats = $result->fetch_assoc();
        $result->close();
    }
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 5;
$offset = ($page - 1) * $per_page;

$stmt = $conn->prepare("CALL sp_get_user_reservation_count(?)");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$total_result = $stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_reservations = $total_row['total'];
$total_pages = ceil($total_reservations / $per_page);
$stmt->close();
$conn->next_result();

$stmt = $conn->prepare("CALL sp_get_user_reservations_paginated(?, ?, ?)");
$stmt->bind_param("iii", $_SESSION['user_id'], $per_page, $offset);
$stmt->execute();
$reservations = $stmt->get_result();
$stmt->close();
$conn->next_result();

if (isset($_POST['cancel_reservation'])) {
    $reservation_id = $_POST['reservation_id'];
    $stmt = $conn->prepare("CALL sp_cancel_reservation(?, ?)");
    $stmt->bind_param("ii", $reservation_id, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
    $conn->next_result();
    header('Location: dashboard.php');
    exit();
}

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Hotel Reservation System</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
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
                <p><i class="fas fa-user"></i> Customer</p>
            </div>
        </div>
        
        <div class="sidebar-menu">
            <a href="dashboard.php" class="menu-item active">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            <a href="booking.php" class="menu-item">
                <i class="fas fa-calendar-check"></i>
                <span>Book Room</span>
            </a>
            
            <div class="menu-divider"></div>
            
            <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager'): ?>
            <a href="admin_dashboard.php" class="menu-item">
                <i class="fas fa-user-shield"></i>
                <span>Admin Panel</span>
            </a>
            <?php endif; ?>
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
                <h1 class="playfair">Dashboard</h1>
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
                <p>Manage your reservations and bookings</p>
            </div>
            
            <?php if ($stats): ?>
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
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-value">
                            <h3><?php echo $stats['confirmed_reservations']; ?></h3>
                            <p>Confirmed Reservations</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="section">
                <div class="section-header">
                    <h3 class="playfair"><i class="fas fa-calendar-alt"></i> My Reservations</h3>
                </div>
                <?php if ($reservations && $reservations->num_rows > 0): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag"></i> ID</th>
                                <th><i class="fas fa-door-closed"></i> Room</th>
                                <th><i class="fas fa-bed"></i> Type</th>
                                <th><i class="fas fa-calendar-check"></i> Check-In</th>
                                <th><i class="fas fa-calendar-times"></i> Check-Out</th>
                                <th><i class="fas fa-money-bill-wave"></i> Amount</th>
                                <th><i class="fas fa-info-circle"></i> Status</th>
                                <th><i class="fas fa-cog"></i> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $reservations->fetch_assoc()): ?>
                            <tr>
                                <td><strong><?php echo $row['reservation_id']; ?></strong></td>
                                <td><?php echo htmlspecialchars($row['room_number']); ?></td>
                                <td><?php echo htmlspecialchars($row['type_name']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($row['check_in_date'])); ?></td>
                                <td><?php echo date('M d, Y', strtotime($row['check_out_date'])); ?></td>
                                <td>₱<?php echo number_format($row['total_amount'], 2); ?></td>
                                <td><span class="status <?php echo $row['status']; ?>"><?php echo ucfirst(str_replace('_', ' ', $row['status'])); ?></span></td>
                                <td>
                                    <div class="action-buttons">
                                        <?php if ($row['status'] === 'pending'): ?>
                                            <a href="payment.php?id=<?php echo $row['reservation_id']; ?>" class="btn btn-small">
                                                <i class="fas fa-credit-card"></i>
                                                Pay Now
                                            </a>
                                            <button type="button" class="btn btn-small btn-danger" onclick="openCancelModal(<?php echo $row['reservation_id']; ?>, '<?php echo htmlspecialchars($row['room_number']); ?>', '<?php echo htmlspecialchars($row['type_name']); ?>', '<?php echo date('M d, Y', strtotime($row['check_in_date'])); ?>', '<?php echo date('M d, Y', strtotime($row['check_out_date'])); ?>', '<?php echo number_format($row['total_amount'], 2); ?>')">
                                                <i class="fas fa-times"></i>
                                                Cancel
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>"><i class="fas fa-chevron-left"></i> Previous</a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <?php if ($i == $page): ?>
                            <span class="active"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>">Next <i class="fas fa-chevron-right"></i></a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <p>You don't have any reservations yet.</p>
                    <a href="booking.php" class="btn" style="margin-top: 20px;">
                        <i class="fas fa-plus-circle"></i>
                        Make a Reservation
                    </a>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="section">
                <div class="section-header">
                    <h3 class="playfair"><i class="fas fa-bell"></i> Recent Notifications</h3>
                </div>
                <div id="notifications-container">
                    <div class="loading">Loading notifications...</div>
                </div>
            </div>
        </div>
    </div>

    <div id="cancelModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fas fa-exclamation-triangle"></i>
                <h2>Cancel Reservation</h2>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this reservation? This action cannot be undone.</p>
                <div class="reservation-details" id="modalReservationDetails">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-cancel" onclick="closeCancelModal()">
                    <i class="fas fa-times"></i>
                    No, Keep It
                </button>
                <form method="POST" style="display: inline;" id="cancelForm">
                    <input type="hidden" name="reservation_id" id="modalReservationId">
                    <button type="submit" name="cancel_reservation" class="modal-btn modal-btn-confirm">
                        <i class="fas fa-check"></i>
                        Yes, Cancel It
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentNotifPage = 1;
        const userId = <?php echo $_SESSION['user_id']; ?>;

        function openCancelModal(id, room, type, checkIn, checkOut, amount) {
            document.getElementById('modalReservationId').value = id;
            document.getElementById('modalReservationDetails').innerHTML = `
                <p><strong>Reservation ID:</strong> <span>#${id}</span></p>
                <p><strong>Room:</strong> <span>${room}</span></p>
                <p><strong>Type:</strong> <span>${type}</span></p>
                <p><strong>Check-In:</strong> <span>${checkIn}</span></p>
                <p><strong>Check-Out:</strong> <span>${checkOut}</span></p>
                <p><strong>Amount:</strong> <span>₱${amount}</span></p>
            `;
            document.getElementById('cancelModal').style.display = 'block';
        }

        function closeCancelModal() {
            document.getElementById('cancelModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('cancelModal');
            if (event.target == modal) {
                closeCancelModal();
            }
        }

        function loadNotifications(page) {
            fetch(`get_notifications.php?user_id=${userId}&page=${page}`)
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('notifications-container');
                    
                    if (data.notifications.length === 0 && page === 1) {
                        container.innerHTML = `
                            <div class="empty-state">
                                <i class="fas fa-bell-slash"></i>
                                <p>No notifications</p>
                            </div>
                        `;
                        return;
                    }
                    
                    let html = '';
                    data.notifications.forEach(notif => {
                        const date = new Date(notif.created_at);
                        const formattedDate = date.toLocaleDateString('en-US', { 
                            month: 'short', 
                            day: 'numeric', 
                            year: 'numeric',
                            hour: 'numeric',
                            minute: '2-digit',
                            hour12: true
                        });
                        
                        html += `
                            <div class="notification ${notif.is_read == 0 ? 'unread' : ''}">
                                <p>${escapeHtml(notif.message)}</p>
                                <div class="notification-time">
                                    <i class="fas fa-clock"></i>
                                    ${formattedDate}
                                </div>
                            </div>
                        `;
                    });
                    
                    if (data.total_pages > 1) {
                        html += '<div class="pagination">';
                        
                        if (page > 1) {
                            html += `<a href="#" onclick="loadNotifications(${page - 1}); return false;"><i class="fas fa-chevron-left"></i> Previous</a>`;
                        }
                        
                        for (let i = 1; i <= data.total_pages; i++) {
                            if (i === page) {
                                html += `<span class="active">${i}</span>`;
                            } else {
                                html += `<a href="#" onclick="loadNotifications(${i}); return false;">${i}</a>`;
                            }
                        }
                        
                        if (page < data.total_pages) {
                            html += `<a href="#" onclick="loadNotifications(${page + 1}); return false;">Next <i class="fas fa-chevron-right"></i></a>`;
                        }
                        
                        html += '</div>';
                    }
                    
                    container.innerHTML = html;
                    currentNotifPage = page;
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                    document.getElementById('notifications-container').innerHTML = `
                        <div class="empty-state">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p>Error loading notifications</p>
                        </div>
                    `;
                });
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        loadNotifications(1);
    </script>
</body>
</html>