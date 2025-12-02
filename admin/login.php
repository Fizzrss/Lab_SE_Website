<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// include "../includes/config.php";
include "../helpers/flash_message.php";

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LAB SE Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #6096B4;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-wrapper {
            background: white;
            border-radius: 30px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            display: flex;
            animation: slideUp 0.6s ease;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-left {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-right {
            flex: 1;
            background: #f8f9fd;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #6096B4;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo i {
            font-size: 2rem;
        }
        
        .login-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 10px;
        }
        
        .login-subtitle {
            color: #6c757d;
            margin-bottom: 40px;
            font-size: 0.95rem;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-label {
            display: block;
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
            font-size: 0.875rem;
        }
        
        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #6096B4;
            background: white;
            box-shadow: 0 0 0 4px rgba(72, 69, 210, 0.1);
        }
        
        .password-wrapper {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            transition: color 0.3s ease;
        }
        
        .password-toggle:hover {
            color: #6096B4;
        }
        
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-check-input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            border: 2px solid #dee2e6;
        }
        
        .form-check-input:checked {
            background-color: #6096B4;
            border-color: #6096B4;
        }
        
        .form-check-label {
            font-size: 0.875rem;
            color: #495057;
            cursor: pointer;
        }
        
        .forgot-link {
            color: #6096B4;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .forgot-link:hover {
            color: #3835a0;
            text-decoration: underline;
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background: #6096B4;
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(72, 69, 210, 0.3);
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(72, 69, 210, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .signup-text {
            text-align: center;
            margin-top: 24px;
            font-size: 0.875rem;
            color: #6c757d;
        }
        
        .signup-text a {
            color: #6096B4;
            text-decoration: none;
            font-weight: 600;
        }
        
        .signup-text a:hover {
            text-decoration: underline;
        }
        
        /* Right side illustration */
        .illustration {
            max-width: 100%;
            margin-bottom: 30px;
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }
        
        .right-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 15px;
        }
        
        .right-description {
            color: #6c757d;
            font-size: 0.95rem;
            line-height: 1.6;
            max-width: 400px;
            margin: 0 auto 30px;
        }
        
        .carousel-indicators {
            margin-bottom: 0;
        }
        
        .carousel-indicators button {
            width: 40px;
            height: 4px;
            border-radius: 2px;
            border: none;
            background-color: #cbd5e0;
            opacity: 1;
        }
        
        .carousel-indicators button.active {
            background-color: #6096B4;
        }
        
        /* Alert customization */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 12px 16px;
            margin-bottom: 24px;
            font-size: 0.875rem;
        }
        
        .alert-danger {
            background-color: #fee;
            color: #c33;
        }
        
        .alert-success {
            background-color: #efe;
            color: #3c3;
        }
        
        /* Loading state */
        .btn-login .spinner-border {
            width: 20px;
            height: 20px;
            border-width: 2px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
                border-radius: 20px;
            }
            
            .login-left,
            .login-right {
                padding: 40px 30px;
            }
            
            .login-right {
                order: -1;
            }
            
            .illustration {
                max-width: 80%;
            }
            
            .right-title {
                font-size: 1.25rem;
            }
            
            .login-title {
                font-size: 1.75rem;
            }
        }
        
        @media (max-width: 576px) {
            body {
                padding: 10px;
            }
            
            .login-left,
            .login-right {
                padding: 30px 20px;
            }
            
            .login-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Left Side - Form -->
        <div class="login-left">
            
            <h1 class="login-title">Login</h1>
            <p class="login-subtitle">Welcome back! Please enter your details</p>
            
            <?php if (isset($_SESSION['_flashdata'])) {
                foreach ($_SESSION['_flashdata'] as $key => $val) {
                    echo get_flashdata($key);
                }
            }
            ?>
            <?php // FlashMessage::display(); ?>
            
            <form method="POST" action="../controllers/AuthController.php" id="loginForm">
                <div class="form-group">
                    <label class="form-label">Username or email</label>
                    <input type="text" 
                           class="form-control" 
                           name="username" 
                           placeholder="Enter your username"
                           required
                           autofocus>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="password-wrapper">
                        <input type="password" 
                               class="form-control" 
                               id="password" 
                               name="password" 
                               placeholder="Enter your password"
                               required>
                        <span class="password-toggle" onclick="togglePassword()">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </span>
                    </div>
                </div>
                
                <div class="form-options">
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="rememberMe">
                        <label class="form-check-label" for="rememberMe">
                            Remember me
                        </label>
                    </div>
                    <a href="#" class="forgot-link" data-bs-toggle="modal" data-bs-target="#forgotModal">
                        Forgot password?
                    </a>
                </div>
                
                <button type="submit" class="btn-login" id="btnLogin">
                    <span id="btnText">Login</span>
                    <span id="btnLoading" style="display: none;">
                        <span class="spinner-border spinner-border-sm me-2"></span>
                        Loading...
                    </span>
                </button>
            </form> 
        </div>
        
        <!-- Right Side - Illustration -->
        <div class="login-right">
            <img src="assets/img/LAB SE_Outline.png" 
                 alt="Illustration" 
                 class="illustration">
        </div>
    </div>
    
    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none;">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Forgot Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 pb-4">
                    <p class="text-muted mb-3">
                        Please contact the administrator to reset your password.
                    </p>
                    <div class="alert alert-info d-flex align-items-center mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        <div>
                            <strong>Email:</strong> admin@labse.ac.id<br>
                            <strong>Phone:</strong> 0341-123456
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }
        
        // Form submit with loading
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('btnLogin');
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');
            
            btn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline-block';
        });
        
        // Auto dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Carousel indicators animation (optional)
        let currentSlide = 0;
        const indicators = document.querySelectorAll('.carousel-indicators button');
        
        setInterval(() => {
            indicators[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % indicators.length;
            indicators[currentSlide].classList.add('active');
        }, 3000);
    </script>
</body>
</html>