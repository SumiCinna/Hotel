<?php
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit();
}

$reservation_id = intval($_GET['id']);
$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("SELECT r.*, rm.room_number, rt.type_name, rt.base_price 
                        FROM reservations r 
                        JOIN rooms rm ON r.room_id = rm.room_id 
                        JOIN room_types rt ON rm.room_type_id = rt.room_type_id 
                        WHERE r.reservation_id = ? AND r.user_id = ?");
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
    $amount = $reservation['total_amount'];
    $transaction_id = 'TXN' . time() . rand(1000, 9999);
    
    $stmt = $conn->prepare("CALL sp_process_payment(?, ?, ?, ?)");
    $stmt->bind_param("idss", $reservation_id, $amount, $payment_method, $transaction_id);
    
    if ($stmt->execute()) {
        $success = 'Payment processed successfully! Your reservation is confirmed.';
        header('refresh:2;url=dashboard.php');
    } else {
        $error = 'Payment processing failed. Please try again.';
    }
    
    $stmt->close();
    $conn->next_result();
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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .payment-card {
            background: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        h2 {
            color: #667eea;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
        }
        
        .reservation-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #333;
        }
        
        .detail-value {
            color: #666;
        }
        
        .total-amount {
            background: #667eea;
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .total-amount h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .total-amount .amount {
            font-size: 36px;
            font-weight: bold;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }
        
        select, input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        select:focus, input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .btn {
            width: 100%;
            padding: 15px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .error {
            background: #fee;
            color: #c33;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
        }
        
        .success {
            background: #efe;
            color: #3c3;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #3c3;
        }
        
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .payment-methods {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .payment-method {
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .payment-method:hover {
            border-color: #667eea;
            background: #f8f9ff;
        }
        
        .payment-method input[type="radio"] {
            margin-right: 8px;
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
            
            <?php if($success): ?>
                <div class="success"><?php echo htmlspecialchars($success); ?></div>
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
</body>
</html>