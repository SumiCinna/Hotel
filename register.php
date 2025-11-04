<?php
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = trim($_POST['email']);
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $terms_accepted = isset($_POST['terms_accepted']) ? true : false;
    
    if (empty($username) || empty($password) || empty($email) || empty($full_name)) {
        $error = 'Username, email, full name, and password are required';
    } elseif (strlen($username) > 30) {
        $error = 'Username must not exceed 30 characters';
    } elseif (strlen($email) > 100) {
        $error = 'Email must not exceed 100 characters';
    } elseif (strlen($full_name) > 60) {
        $error = 'Full name must not exceed 60 characters';
    } elseif (strlen($password) > 50) {
        $error = 'Password must not exceed 50 characters';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format';
    } elseif (!preg_match('/@/', $email) || !preg_match('/\.com$/', $email)) {
        $error = 'Email must contain @ and end with .com';
    } elseif (!empty($phone) && !preg_match('/^[0-9]{1,11}$/', $phone)) {
        $error = 'Phone number must contain only digits and be up to 11 numbers';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters';
    } elseif (!$terms_accepted) {
        $error = 'You must accept the Terms of Service and Privacy Policy';
    } else {
        $db = new Database();
        $conn = $db->getConnection();
        
        if (!empty($phone)) {
            $stmt_check_phone = $conn->prepare("CALL sp_check_phone_exists(?)");
            if (!$stmt_check_phone) {
                $error = 'Database statement prepare failed for phone check: ' . $conn->error;
                $db->close();
                goto end_post_processing;
            }
            $stmt_check_phone->bind_param("s", $phone);
            $stmt_check_phone->execute();
            $result_check_phone = $stmt_check_phone->get_result();
            
            if ($result_check_phone->num_rows > 0) {
                $error = 'Phone number is already registered';
            }
            $stmt_check_phone->close();
            while ($conn->next_result()) {
                if ($res = $conn->store_result()) {
                    $res->free();
                }
            }
        }
        
        if (empty($error)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt_register = $conn->prepare("CALL sp_register_user(?, ?, ?, ?, ?, 'customer')");
            
            if (!$stmt_register) {
                $error = 'Database statement prepare failed for user registration: ' . $conn->error;
            } else {
                $stmt_register->bind_param("sssss", $username, $hashed_password, $email, $full_name, $phone);
                
                if ($stmt_register->execute()) {
                    $result_register = $stmt_register->get_result();
                    if ($result_register && $row = $result_register->fetch_assoc()) {
                        if (isset($row['user_id']) && $row['user_id'] > 0) {
                            $success = 'Registration successful! You can now login.';
                        } else {
                            $success = 'Registration successful! You can now login.';
                        }
                    } else {
                        $success = 'Registration successful! You can now login.';
                    }
                } else {
                    if ($conn->errno === 1062 || $conn->sqlstate === '23000') {
                        $error = 'Username or email already exists. Please choose a different one.';
                    } else {
                        $error = 'Registration failed: ' . $stmt_register->error;
                    }
                }
                $stmt_register->close();
                while ($conn->next_result()) {
                    if ($res = $conn->store_result()) {
                        $res->free();
                    }
                }
            }
            $db->close();
        }
    }
    end_post_processing:
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Hotel Reservation System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="register-container">
        <div class="logo-section">
            <div class="logo-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h2>Create Account</h2>
            <p class="subtitle">Join us and start booking</p>
        </div>
        
        <?php if($error): ?>
            <div class="error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if($success): ?>
            <div class="success">
                <i class="fas fa-check-circle"></i>
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="" id="registerForm">
            <div class="form-group">
                <label for="username">Username<span class="required">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" id="username" name="username" maxlength="30" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="email">Email<span class="required">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" id="email" name="email" maxlength="100" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="full_name">Full Name<span class="required">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-id-card input-icon"></i>
                    <input type="text" id="full_name" name="full_name" maxlength="60" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone</label>
                <div class="input-wrapper">
                    <i class="fas fa-phone input-icon"></i>
                    <input type="tel" id="phone" name="phone" maxlength="11" pattern="[0-9]*">
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">Password<span class="required">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" id="password" name="password" maxlength="50" required minlength="8">
                    <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                </div>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password<span class="required">*</span></label>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" id="confirm_password" name="confirm_password" maxlength="50" required>
                    <i class="fas fa-eye password-toggle" id="toggleConfirmPassword"></i>
                </div>
            </div>
            
            <div class="terms-group">
                <input type="checkbox" id="terms_accepted" name="terms_accepted" required>
                <label for="terms_accepted" class="terms-text">
                    I agree to the <a href="#" id="termsLink">Terms of Service</a> and <a href="#" id="privacyLink">Privacy Policy</a><span class="required">*</span>
                </label>
            </div>
            
            <button type="submit" class="btn">
                <i class="fas fa-user-plus" style="margin-right: 8px;"></i>
                Create Account
            </button>
        </form>
        
        <div class="divider">
            <span>OR</span>
        </div>
        
        <div class="links">
            <p>Already have an account? <a href="login.php">Login here</a></p>
            <p><a href="index.php"><i class="fas fa-arrow-left" style="margin-right: 5px;"></i>Back to Home</a></p>
        </div>
    </div>
    
    <div id="termsModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeTerms">&times;</span>
            <h3>Terms of Service</h3>
            <p>By using our services and making a reservation at Hotel MS, you agree to the following terms and conditions:</p>
            <ul>
                <li><strong>Eligibility:</strong> You must be at least 18 years old to make a reservation or book a room at our hotel.</li>
                <li><strong>Reservation Policy:</strong> All reservations must be made through our official website or phone line, or. Upon booking, an invoice will be provided for your reference. Please note that payment is not processed online, and the reservation is confirmed upon receipt of the invoice.</li>
                <li><strong>Check-In/Check-Out:</strong> Late check-outs may incur additional fees unless otherwise arranged with the hotel in advance.</li>
                <li><strong>Identification:</strong> You must present a valid government-issued photo ID and a credit/debit card upon check-in.</li>
                <li><strong>Payment Policy:</strong> Payment for your stay must be made in person at the hotel front desk at the time of check-in. Upon booking, you will receive an invoice for your reservation, which serves as a reference. The payment must be settled at the hotel using accepted payment methods, including credit/debit cards or cash. Please note that payment will be processed when you check in, and your reservation may be canceled if payment is not received at that time.</li>
                <li><strong>Guest Conduct:</strong> Guests are expected to behave in a respectful and lawful manner while staying at the hotel. Any disruptive or illegal behavior may result in eviction from the hotel without refund.</li>
                <li><strong>No Smoking:</strong> Smoking is prohibited in all indoor areas of the hotel, including guest rooms, corridors, and common areas. Smoking is only allowed in designated outdoor smoking areas. Violators may incur a cleaning fee.</li>
                <li><strong>Pets:</strong> Pets are not allowed at our hotel.</li>
                <li><strong>Account Suspension:</strong> Cancellations must be made at least 1 day prior to your scheduled check-in date. Late cancellations or no-shows will result in the suspension of your account.</li>
                <li><strong>Damages:</strong> You are responsible for any damage or loss caused to hotel property during your stay. Any damages will be charged to your credit card on file.</li>
                <li><strong>Hotel Liability:</strong> The hotel is not liable for any loss, theft, or damage to your personal belongings during your stay. Please keep valuables in your room's safe or at the front desk.</li>
                <li><strong>Third-Party Services:</strong> The hotel may offer third-party services such as other amenities. We are not responsible for the actions, services, or liabilities of these third-party providers.</li>
                <li><strong>Force Majeure:</strong> The hotel is not responsible for any disruptions, cancellations, or delays due to unforeseen circumstances, including but not limited to natural disasters, strikes, or government actions.</li>
                <li><strong>Changes to Terms:</strong> We reserve the right to update or modify these Terms of Service at any time. All changes will be posted on this page, and continued use of our services constitutes acceptance of the updated terms.</li>
                <li><strong>Governing Law:</strong> These Terms of Service are governed by the applicable laws of the jurisdiction where the service provider is based. Any disputes will be resolved in the courts of the same jurisdiction.</li>
                <li><strong>Indemnification:</strong> You agree to indemnify and hold harmless HotelMS and its affiliates from any claims, damages, or expenses arising from your use of our services or violations of these terms.</li>
            </ul>
        </div>
    </div>
    
    <div id="privacyModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closePrivacy">&times;</span>
            <h3>Privacy Policy</h3>
            <p>At Hotel MS, we respect your privacy and are committed to protecting your personal information. By using our services and making a reservation, you agree to the following privacy terms:</p>
            <ul>
                <li><strong>Information Collection:</strong> We collect personal information such as your name, email address, phone number, date of birth, picture, address, and reservation preferences when you make a booking or interact with our website.</li>
                <li><strong>Use of Information:</strong> The personal information we collect is used for processing your reservation, improving your experience, sending you booking confirmations, and providing customer support. We may also use your information for marketing purposes if you consent.</li>
                <li><strong>Payment Processing:</strong> We do not process payments online. All payments are made in person at the hotel front desk at the time of check-in. Your payment details are not stored on our website.</li>
                <li><strong>Data Security:</strong> We take appropriate security measures to protect your personal information from unauthorized access, alteration, or destruction. Your data is stored securely.</li>
                <li><strong>Sharing of Information:</strong> We do not sell or rent your personal information to third parties. However, we may share your information with trusted service providers to help us manage your reservation or improve our services.</li>
                <li><strong>Cookies and Tracking:</strong> Our website uses cookies to enhance your browsing experience and track usage patterns. You can control cookies through your browser settings, but some features of the site may not work properly if cookies are disabled.</li>
                <li><strong>Data Retention:</strong> We will retain your personal data for as long as necessary to fulfill the purposes for which it was collected or as required by law. After this period, your data will be securely deleted.</li>
                <li><strong>Your Rights:</strong> You have the right to access, correct, or delete your personal information. If you wish to make any changes or have concerns about how your data is handled, please contact us directly.</li>
                <li><strong>Children's Privacy:</strong> Hotel MS does not knowingly collect personal information from children under the age of 13. If we discover that a child under 13 has provided us with personal information, we will take steps to remove it as soon as possible.</li>
                <li><strong>Policy Changes:</strong> We may update this Privacy Policy from time to time. Any changes will be posted on this page, and continued use of our services will constitute acceptance of the updated policy.</li>
                <li><strong>Governing Law:</strong> This Privacy Policy is governed by the laws of the jurisdiction in which Hotel MS is based. Any disputes regarding privacy will be resolved under the applicable laws.</li>
            </ul>
        </div>
    </div>
    
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPassword = document.getElementById('confirm_password');
        const phoneInput = document.getElementById('phone');
        const emailInput = document.getElementById('email');
        const registerForm = document.getElementById('registerForm');
        

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
        
        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
        
        phoneInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 11) {
                this.value = this.value.slice(0, 11);
            }
        });
        
        registerForm.addEventListener('submit', function(e) {
            const emailValue = emailInput.value;
            if (!emailValue.includes('@') || !emailValue.endsWith('.com')) {
                e.preventDefault();
                alert('Email must contain @ and end with .com');
                return false;
            }
            
            if (password.value.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters');
                return false;
            }
            
            if (password.value !== confirmPassword.value) {
                e.preventDefault();
                alert('Passwords do not match');
                return false;
            }
        });
        
        const termsModal = document.getElementById('termsModal');
        const privacyModal = document.getElementById('privacyModal');
        const termsLink = document.getElementById('termsLink');
        const privacyLink = document.getElementById('privacyLink');
        const closeTerms = document.getElementById('closeTerms');
        const closePrivacy = document.getElementById('closePrivacy');
        
        termsLink.addEventListener('click', function(e) {
            e.preventDefault();
            termsModal.style.display = 'block';
        });
        
        privacyLink.addEventListener('click', function(e) {
            e.preventDefault();
            privacyModal.style.display = 'block';
        });
        
        closeTerms.addEventListener('click', function() {
            termsModal.style.display = 'none';
        });
        
        closePrivacy.addEventListener('click', function() {
            privacyModal.style.display = 'none';
        });
        
        window.addEventListener('click', function(e) {
            if (e.target == termsModal) {
                termsModal.style.display = 'none';
            }
            if (e.target == privacyModal) {
                privacyModal.style.display = 'none';
            }
        });
    </script>
</body>
</html>