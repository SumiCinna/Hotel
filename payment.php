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
$show_receipt = false;
$payment_data = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method'];
    $amount = $reservation['total_amount'];
    $transaction_id = 'TXN' . time() . rand(1000, 9999);
    
    $conn->begin_transaction();
    
    try {
        $stmt = $conn->prepare("CALL sp_insert_payment(?, ?, ?, ?)");
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        
        $stmt->bind_param("idss", $reservation_id, $amount, $payment_method, $transaction_id);
        $stmt->execute();
        $stmt->close();
        
        $stmt = $conn->prepare("CALL sp_update_reservation_status(?, ?)");
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $new_status = 'confirmed';
        $stmt->bind_param("is", $reservation_id, $new_status);
        $stmt->execute();
        $stmt->close();
        
        $conn->commit();
        
        $show_receipt = true;
        $payment_data = [
            'transaction_id' => $transaction_id,
            'payment_method' => $payment_method,
            'amount' => $amount,
            'payment_date' => date('M d, Y h:i A')
        ];
    } catch (Exception $e) {
        $conn->rollback();
        $error = 'Payment processing failed. Please try again. Error: ' . $e->getMessage();
    }
}

$stmt = $conn->prepare("CALL sp_get_user_details(?)");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$user_result = $stmt->get_result();
$user_data = $user_result->fetch_assoc();
$stmt->close();

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
    <style>
        @media print {
            .container {
                display: none !important;
            }
            
            #receiptModal {
                display: block !important;
                position: static !important;
                background: white !important;
            }
            
            .modal-content {
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
            
            .modal-actions {
                display: none !important;
            }
        }
    </style>
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
            <form method="POST">
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
                
                <button type="submit" class="btn">Process Payment</button>
            </form>
            <?php else: ?>
            <div class="success">This reservation has already been paid.</div>
            <?php endif; ?>
            
            <div class="back-link">
                <a href="dashboard.php">← Back to Dashboard</a>
            </div>
        </div>
    </div>

    <?php if($show_receipt && $payment_data): ?>
    <div id="receiptModal" class="modal show">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Payment Receipt</h2>
            </div>
            <div class="modal-body">
                <div class="receipt">
                    <div class="receipt-header">
                        <h1>HOTEL RESERVATION</h1>
                        <p>Official Payment Receipt</p>
                        <p style="margin-top: 10px;"><span class="status-badge">PAID</span></p>
                    </div>

                    <div class="receipt-info">
                        <div class="info-section">
                            <h3>Guest Information</h3>
                            <div class="info-row">
                                <span class="info-label">Name:</span>
                                <span class="info-value"><?php echo htmlspecialchars($user_data['full_name']); ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Email:</span>
                                <span class="info-value"><?php echo htmlspecialchars($user_data['email']); ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Phone:</span>
                                <span class="info-value"><?php echo htmlspecialchars($user_data['phone']); ?></span>
                            </div>
                        </div>

                        <div class="info-section">
                            <h3>Payment Information</h3>
                            <div class="info-row">
                                <span class="info-label">Transaction ID:</span>
                                <span class="info-value"><?php echo htmlspecialchars($payment_data['transaction_id']); ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Payment Date:</span>
                                <span class="info-value"><?php echo $payment_data['payment_date']; ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Payment Method:</span>
                                <span class="info-value"><?php echo ucwords(str_replace('_', ' ', htmlspecialchars($payment_data['payment_method']))); ?></span>
                            </div>
                        </div>
                    </div>

                    <table class="receipt-table">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Details</th>
                                <th style="text-align: right;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Room Reservation</strong><br>
                                    <small>Reservation #<?php echo $reservation['reservation_id']; ?></small>
                                </td>
                                <td>
                                    Room <?php echo htmlspecialchars($reservation['room_number']); ?> - <?php echo htmlspecialchars($reservation['type_name']); ?><br>
                                    <small><?php echo date('M d, Y', strtotime($reservation['check_in_date'])); ?> to <?php echo date('M d, Y', strtotime($reservation['check_out_date'])); ?></small><br>
                                    <small><?php echo $nights; ?> night(s) × ₱<?php echo number_format($reservation['base_price'], 2); ?></small>
                                </td>
                                <td style="text-align: right;">₱<?php echo number_format($reservation['total_amount'], 2); ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="receipt-total">
                        <div class="total-row">
                            <span>Subtotal:</span>
                            <span>₱<?php echo number_format($reservation['total_amount'], 2); ?></span>
                        </div>
                        
                        <div class="total-row grand-total">
                            <span>Total Paid:</span>
                            <span>₱<?php echo number_format($payment_data['amount'], 2); ?></span>
                        </div>
                    </div>

                    <div class="receipt-footer">
                        <p>Thank you for your payment!</p>
                        <p>This is an official receipt. Please keep for your records.</p>
                        <p style="margin-top: 10px;">For inquiries, please contact our front desk.</p>
                    </div>

                    <div class="modal-actions">
                        <button onclick="printReceipt()" class="btn-print">🖨️ Print Receipt</button>
                        <button onclick="closeAndRedirect()" class="btn-close">Close & Go to Dashboard</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script>
        function printReceipt() {
            window.print();
        }

        function closeAndRedirect() {
            window.location.href = 'dashboard.php';
        }
    </script>
</body>
</html>