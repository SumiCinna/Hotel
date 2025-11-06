<?php
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit();
}

$reservation_id = intval($_GET['id']);
$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("CALL sp_get_reservation_details(?, ?)");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ii", $reservation_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows === 0) {
    header('Location: dashboard.php');
    exit();
}

$reservation = $result->fetch_assoc();
$stmt->close();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method'];
    $amount_paid = floatval($_POST['amount_paid']);
    $total_amount = $reservation['total_amount'];
    $transaction_id = 'TXN' . time() . rand(1000, 9999);
    
    if ($amount_paid < $total_amount) {
        $error = 'Insufficient payment amount. Please pay at least ₱' . number_format($total_amount, 2);
    } else {
        $change = $amount_paid - $total_amount;
        
        $conn->begin_transaction();
        
        try {
            $stmt = $conn->prepare("CALL sp_insert_payment(?, ?, ?, ?)");
            
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            
            $stmt->bind_param("idss", $reservation_id, $amount_paid, $payment_method, $transaction_id);
            $stmt->execute();
            $stmt->close();
            
            $stmt = $conn->prepare("CALL sp_update_reservation_status(?, ?)");
            
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $new_status = 'pending_approval';
            $stmt->bind_param("is", $reservation_id, $new_status);
            $stmt->execute();
            $stmt->close();
            
            $conn->commit();
            
            header('Location: dashboard.php?payment_success=1');
            exit();
        } catch (Exception $e) {
            $conn->rollback();
            $error = 'Payment processing failed. Please try again. Error: ' . $e->getMessage();
        }
    }
}

$db->close();

$nights = (strtotime($reservation['check_out_date']) - strtotime($reservation['check_in_date'])) / (60 * 60 * 24);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Hotel Reservation System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/payment.css">
  
</head>
<body>
    <div class="container">
        <div class="payment-card">
            <h2>Complete Your Payment</h2>
            
            <?php if($error): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <div class="reservation-details">
                <h3 style="color: #333; margin-bottom: 15px;">Reservation Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Reservation ID:</span>
                    <span class="detail-value">#<?php echo $reservation['reservation_id']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Room Number:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($reservation['room_number']); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Room Type:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($reservation['type_name']); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Check-In:</span>
                    <span class="detail-value"><?php echo date('M d, Y', strtotime($reservation['check_in_date'])); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Check-Out:</span>
                    <span class="detail-value"><?php echo date('M d, Y', strtotime($reservation['check_out_date'])); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Number of Nights:</span>
                    <span class="detail-value"><?php echo $nights; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Price per Night:</span>
                    <span class="detail-value">₱<?php echo number_format($reservation['base_price'], 2); ?></span>
                </div>
            </div>
            
            <div class="total-amount">
                <h3>Total Amount</h3>
                <div class="amount">₱<?php echo number_format($reservation['total_amount'], 2); ?></div>
            </div>
            
            <?php if($reservation['status'] === 'pending'): ?>
            <form method="POST" id="paymentForm">
                <div class="form-group">
                    <label>Select Payment Method</label>
                    <div class="payment-methods">
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="cash" required>
                            💵 Cash
                        </label>
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="credit_card">
                            💳 Credit Card
                        </label>
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="debit_card">
                            💳 Debit Card
                        </label>
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="online">
                            🌐 Online Payment
                        </label>
                    </div>
                </div>
                
                <button type="button" class="btn" onclick="openPaymentModal()">Process Payment</button>
            </form>
            <?php else: ?>
            <div class="success">This reservation has already been paid.</div>
            <?php endif; ?>
            
            <div class="back-link">
                <a href="dashboard.php">← Back to Dashboard</a>
            </div>
        </div>
    </div>

    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fas fa-money-bill-wave"></i>
                <h2>Enter Payment Amount</h2>
            </div>
            <div class="modal-body">
                <div class="error-message" id="modalError">
                    <i class="fas fa-exclamation-circle"></i>
                    <span id="modalErrorText"></span>
                </div>
                
                <div class="payment-summary">
                    <div class="summary-row">
                        <span class="summary-label">Reservation #</span>
                        <span class="summary-value"><?php echo $reservation['reservation_id']; ?></span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Room</span>
                        <span class="summary-value"><?php echo htmlspecialchars($reservation['room_number']); ?> - <?php echo htmlspecialchars($reservation['type_name']); ?></span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Payment Method</span>
                        <span class="summary-value" id="selectedMethodDisplay"></span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Total Amount Due</span>
                        <span class="summary-value">₱<?php echo number_format($reservation['total_amount'], 2); ?></span>
                    </div>
                </div>
                
                <div class="form-group-modal">
                    <label><i class="fas fa-peso-sign"></i> Amount Paid</label>
                    <input type="number" step="0.01" id="modalAmountPaid" placeholder="Enter amount paid" min="<?php echo $reservation['total_amount']; ?>" maxlength="10" oninput="limitDigits(this)">
                    <small>Minimum: ₱<?php echo number_format($reservation['total_amount'], 2); ?></small>
                </div>
                
                <div class="form-group-modal" id="changeDisplay" style="display: none;">
                    <label><i class="fas fa-hand-holding-usd"></i> Change</label>
                    <input type="text" id="changeAmount" readonly style="background: #f1f5f9; font-weight: 700; color: #059669;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal btn-cancel" onclick="closePaymentModal()">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <button type="button" class="btn-modal btn-confirm" onclick="confirmPayment()">
                    <i class="fas fa-check"></i>
                    Confirm Payment
                </button>
            </div>
        </div>
    </div>

    <script>
        const totalAmount = <?php echo $reservation['total_amount']; ?>;
        
        function limitDigits(input) {
            let value = input.value.replace(/[^\d.]/g, '');
            
            const parts = value.split('.');
            if (parts[0].length > 7) {
                parts[0] = parts[0].substring(0, 7);
            }
            
            if (parts.length > 1) {
                value = parts[0] + '.' + parts[1].substring(0, 2);
            } else {
                value = parts[0];
            }
            
            input.value = value;
        }
        
        function openPaymentModal() {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            
            if (!paymentMethod) {
                alert('Please select a payment method first.');
                return;
            }
            
            const methodText = paymentMethod.value.replace('_', ' ').toUpperCase();
            document.getElementById('selectedMethodDisplay').textContent = methodText;
            document.getElementById('paymentModal').classList.add('show');
            document.getElementById('modalAmountPaid').focus();
        }
        
        function closePaymentModal() {
            document.getElementById('paymentModal').classList.remove('show');
            document.getElementById('modalAmountPaid').value = '';
            document.getElementById('changeDisplay').style.display = 'none';
            document.getElementById('modalError').classList.remove('show');
        }
        
        document.getElementById('modalAmountPaid').addEventListener('input', function() {
            const amountPaid = parseFloat(this.value) || 0;
            
            if (amountPaid >= totalAmount) {
                const change = amountPaid - totalAmount;
                document.getElementById('changeAmount').value = '₱' + change.toFixed(2);
                document.getElementById('changeDisplay').style.display = 'block';
                document.getElementById('modalError').classList.remove('show');
            } else {
                document.getElementById('changeDisplay').style.display = 'none';
            }
        });
        
        function confirmPayment() {
            const amountPaid = parseFloat(document.getElementById('modalAmountPaid').value) || 0;
            
            if (amountPaid < totalAmount) {
                document.getElementById('modalErrorText').textContent = 'Insufficient amount! Please pay at least ₱' + totalAmount.toFixed(2);
                document.getElementById('modalError').classList.add('show');
                return;
            }
            
            const form = document.getElementById('paymentForm');
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'amount_paid';
            hiddenInput.value = amountPaid;
            form.appendChild(hiddenInput);
            form.submit();
        }
        
        window.onclick = function(event) {
            const modal = document.getElementById('paymentModal');
            if (event.target == modal) {
                closePaymentModal();
            }
        }
    </script>
</body>
</html>