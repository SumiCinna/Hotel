<?php
require_once 'config.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$db = new Database();
$conn = $db->getConnection();

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$role_filter = isset($_GET['role']) ? trim($_GET['role']) : '';

$where_conditions = [];
$count_where_conditions = [];

if (!empty($search)) {
    $search_escaped = $conn->real_escape_string($search);
    $search_condition = "(username LIKE '%{$search_escaped}%' OR email LIKE '%{$search_escaped}%' OR full_name LIKE '%{$search_escaped}%' OR phone LIKE '%{$search_escaped}%')";
    $where_conditions[] = $search_condition;
    $count_where_conditions[] = $search_condition;
}

if (!empty($role_filter)) {
    $role_escaped = $conn->real_escape_string($role_filter);
    $role_condition = "role = '{$role_escaped}'";
    $where_conditions[] = $role_condition;
    $count_where_conditions[] = $role_condition;
}

$where_clause = '';
$count_where_clause = '';

if (!empty($where_conditions)) {
    $where_clause = " WHERE " . implode(" AND ", $where_conditions);
}

if (!empty($count_where_conditions)) {
    $count_where_clause = " WHERE " . implode(" AND ", $count_where_conditions);
}

$total_result = $conn->query("SELECT COUNT(*) as total FROM users{$count_where_clause}");
$total_row = $total_result->fetch_assoc();
$total_users = $total_row['total'];
$total_pages = ceil($total_users / $per_page);

$users = $conn->query("SELECT user_id, username, email, full_name, phone, role, is_active, created_at FROM users{$where_clause} ORDER BY created_at DESC LIMIT $per_page OFFSET $offset");

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="css/manage_users.css"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Hotel Reservation System</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                <p><i class="fas fa-user-shield"></i> Administrator</p>
            </div>
        </div>
        
        <div class="sidebar-menu">
            <a href="admin_dashboard.php" class="menu-item">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            <a href="manage_users.php" class="menu-item active">
                <i class="fas fa-users"></i>
                <span>Manage Users</span>
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
                <h1 class="playfair">Manage Users</h1>
                <div class="breadcrumb">
                    <span>Home</span>
                    <i class="fas fa-chevron-right"></i>
                    <span>Manage Users</span>
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
                    <h3 class="playfair"><i class="fas fa-users"></i> All Users</h3>
                    <p class="user-count">Total Users: <?php echo $total_users; ?></p>
                </div>
                
                <div class="search-filter-container">
                    <form method="GET" action="manage_users.php" class="search-form">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" name="search" placeholder="Search by username, name, email, or phone..." value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                        <div class="filter-box">
                            <i class="fas fa-filter"></i>
                            <select name="role">
                                <option value="">All Roles</option>
                                <option value="customer" <?php echo $role_filter === 'customer' ? 'selected' : ''; ?>>Customer</option>
                                <option value="staff" <?php echo $role_filter === 'staff' ? 'selected' : ''; ?>>Staff</option>
                                <option value="admin" <?php echo $role_filter === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                <option value="manager" <?php echo $role_filter === 'manager' ? 'selected' : ''; ?>>Manager</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-search">
                            <i class="fas fa-search"></i>
                            Search
                        </button>
                        <?php if (!empty($search) || !empty($role_filter)): ?>
                        <a href="manage_users.php" class="btn-reset">
                            <i class="fas fa-times"></i>
                            Reset
                        </a>
                        <?php endif; ?>
                    </form>
                </div>
                
                <?php if ($users && $users->num_rows > 0): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag"></i> ID</th>
                                <th><i class="fas fa-user"></i> Username</th>
                                <th><i class="fas fa-id-card"></i> Full Name</th>
                                <th><i class="fas fa-envelope"></i> Email</th>
                                <th><i class="fas fa-phone"></i> Phone</th>
                                <th><i class="fas fa-user-tag"></i> Role</th>
                                <th><i class="fas fa-toggle-on"></i> Status</th>
                                <th><i class="fas fa-cog"></i> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($user = $users->fetch_assoc()): ?>
                            <tr>
                                <td><strong><?php echo $user['user_id']; ?></strong></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['phone']); ?></td>
                                <td><strong><?php echo ucfirst($user['role']); ?></strong></td>
                                <td>
                                    <?php if ($user['is_active']): ?>
                                        <span class="badge-active">Active</span>
                                    <?php else: ?>
                                        <span class="badge-inactive">Deactivated</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit_user.php?id=<?php echo $user['user_id']; ?>" class="btn btn-small">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <div class="pagination-info">
                        Showing <?php echo (($page - 1) * $per_page) + 1; ?> to <?php echo min($page * $per_page, $total_users); ?> of <?php echo $total_users; ?> users
                    </div>
                    <div class="pagination-controls">
                        <?php
                        $query_params = [];
                        if (!empty($search)) $query_params[] = "search=" . urlencode($search);
                        if (!empty($role_filter)) $query_params[] = "role=" . urlencode($role_filter);
                        $query_string = !empty($query_params) ? "&" . implode("&", $query_params) : "";
                        ?>
                        
                        <?php if ($page > 1): ?>
                            <a href="?page=1<?php echo $query_string; ?>" class="pagination-btn" title="First Page">
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                            <a href="?page=<?php echo $page - 1; ?><?php echo $query_string; ?>" class="pagination-btn" title="Previous">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php
                        $start_page = max(1, $page - 2);
                        $end_page = min($total_pages, $page + 2);
                        
                        if ($start_page > 1): ?>
                            <a href="?page=1<?php echo $query_string; ?>" class="pagination-btn">1</a>
                            <?php if ($start_page > 2): ?>
                                <span class="pagination-ellipsis">...</span>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                            <a href="?page=<?php echo $i; ?><?php echo $query_string; ?>" class="pagination-btn <?php echo $i === $page ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if ($end_page < $total_pages): ?>
                            <?php if ($end_page < $total_pages - 1): ?>
                                <span class="pagination-ellipsis">...</span>
                            <?php endif; ?>
                            <a href="?page=<?php echo $total_pages; ?><?php echo $query_string; ?>" class="pagination-btn"><?php echo $total_pages; ?></a>
                        <?php endif; ?>
                        
                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?php echo $page + 1; ?><?php echo $query_string; ?>" class="pagination-btn" title="Next">
                                <i class="fas fa-angle-right"></i>
                            </a>
                            <a href="?page=<?php echo $total_pages; ?><?php echo $query_string; ?>" class="pagination-btn" title="Last Page">
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <p>No users found</p>
                    <?php if (!empty($search) || !empty($role_filter)): ?>
                        <a href="manage_users.php" class="btn">Clear Filters</a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>