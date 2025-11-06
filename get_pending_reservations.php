<?php
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    exit('Unauthorized');
}

$db = new Database();
$conn = $db->getConnection();

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$per_page = 5;
$offset = ($page - 1) * $per_page;

$total_pending_row = $conn->query("SELECT * FROM vw_staff_total_pending_count")->fetch_assoc();
$total_pending = $total_pending_row['count'];
$total_pages = ceil($total_pending / $per_page);

$pending_reservations = $conn->query("SELECT * FROM vw_staff_pending_reservations LIMIT $offset, $per_page");

if ($pending_reservations && $pending_reservations->num_rows > 0):
?>
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

<?php
$db->close();
?>