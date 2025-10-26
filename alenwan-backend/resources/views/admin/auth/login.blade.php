<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - Alenwan</title>

    <!-- Bootstrap CSS with RTL support -->
    @if(app()->getLocale() === 'ar')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #a20136;
            --primary-gradient: linear-gradient(135deg, #a20136 0%, #7a0129 100%);
            --secondary-color: #d4154e;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --light-color: #ffffff;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #a20136 0%, #7a0129 50%, #1a1a1a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="grad" cx="50%" cy="50%" r="50%"><stop offset="0%" style="stop-color:%23a20136;stop-opacity:0.1"/><stop offset="100%" style="stop-color:%237a0129;stop-opacity:0"/></radialGradient></defs><circle cx="500" cy="500" r="500" fill="url(%23grad)"/></svg>');
            animation: float 8s ease-in-out infinite;
            z-index: 1;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1) rotate(0deg); }
            33% { transform: translate(-30px, -30px) scale(1.05) rotate(5deg); }
            66% { transform: translate(20px, -20px) scale(0.95) rotate(-3deg); }
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
            padding: 2rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 2rem;
            padding: 3rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 35px 70px -12px rgba(0, 0, 0, 0.3);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo {
            width: 80px;
            height: 80px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
            box-shadow: 0 10px 25px rgba(162, 1, 54, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .login-title {
            color: var(--dark-color);
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: #6b7280;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            color: var(--dark-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.8);
            border: 2px solid #e5e7eb;
            border-radius: 1rem;
            padding: 1rem 1rem 1rem 3rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 2.5rem;
            color: #9ca3af;
            font-size: 1.1rem;
            z-index: 5;
        }

        [dir="rtl"] .input-icon {
            left: auto;
            right: 1rem;
        }

        [dir="rtl"] .form-control {
            padding: 1rem 3rem 1rem 1rem;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 2.5rem;
            color: #9ca3af;
            cursor: pointer;
            font-size: 1.1rem;
            transition: color 0.3s ease;
            z-index: 5;
        }

        [dir="rtl"] .password-toggle {
            right: auto;
            left: 1rem;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        .btn-login {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 1rem 2rem;
            border-radius: 1rem;
            font-weight: 600;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(162, 1, 54, 0.4);
            color: white;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1.5rem 0;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-check-input {
            width: 1.25rem;
            height: 1.25rem;
            margin: 0;
        }

        .form-check-label {
            color: #6b7280;
            font-size: 0.95rem;
            cursor: pointer;
        }

        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: opacity 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--primary-color);
            opacity: 0.8;
        }

        .demo-credentials {
            background: rgba(16, 185, 129, 0.1);
            border-left: 4px solid var(--success-color);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .demo-credentials h6 {
            color: var(--success-color);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .demo-credentials p {
            margin: 0;
            color: #047857;
        }

        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 0.5rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .alert {
            border-radius: 1rem;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #047857;
            border-left: 4px solid var(--success-color);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #b91c1c;
            border-left: 4px solid var(--danger-color);
        }

        .back-to-site {
            position: absolute;
            top: 2rem;
            left: 2rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.75rem 1.5rem;
            border-radius: 2rem;
            backdrop-filter: blur(10px);
        }

        [dir="rtl"] .back-to-site {
            left: auto;
            right: 2rem;
        }

        .back-to-site:hover {
            color: white;
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .login-container {
                padding: 1rem;
            }

            .login-card {
                padding: 2rem 1.5rem;
                border-radius: 1.5rem;
            }

            .back-to-site {
                top: 1rem;
                left: 1rem;
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }

            [dir="rtl"] .back-to-site {
                left: auto;
                right: 1rem;
            }

            .remember-forgot {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }
        }

        /* Animations for form validation */
        .form-control.error {
            border-color: var(--danger-color);
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Floating particles animation */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 2;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: float-particle 15s infinite linear;
        }

        @keyframes float-particle {
            0% {
                transform: translateY(100vh) translateX(0px);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) translateX(100px);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Floating particles -->
    <div class="particles"></div>

    <!-- Back to site link -->
    <a href="{{ route('landing') }}" class="back-to-site">
        <i class="fas fa-arrow-left me-2"></i>{{ __('admin.back_to_site') }}
    </a>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <i class="fas fa-film"></i>
                </div>
                <h1 class="login-title">{{ __('admin.admin_login') }}</h1>
                <p class="login-subtitle">{{ __('admin.sign_in_to_admin_panel') }}</p>
            </div>

            <div id="alertContainer"></div>

            <form id="loginForm">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">{{ __('admin.email_address') }}</label>
                    <div class="position-relative">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="{{ __('admin.enter_your_email') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">{{ __('admin.password') }}</label>
                    <div class="position-relative">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="{{ __('admin.enter_your_password') }}" required>
                        <i class="fas fa-eye password-toggle" id="passwordToggle" onclick="togglePassword()"></i>
                    </div>
                </div>

                <div class="remember-forgot">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            {{ __('admin.remember_me') }}
                        </label>
                    </div>
                    <a href="#" class="forgot-password">{{ __('admin.forgot_password') }}</a>
                </div>

                <button type="submit" class="btn-login">
                    <span class="loading-spinner" id="loadingSpinner"></span>
                    <span id="loginText">{{ __('admin.sign_in') }}</span>
                </button>
            </form>

            <div class="demo-credentials">
                <h6><i class="fas fa-info-circle me-2"></i>{{ __('admin.demo_credentials') }}</h6>
                <p><strong>{{ __('admin.email') }}:</strong> admin@alenwan.com</p>
                <p><strong>{{ __('admin.password') }}:</strong> admin123</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Create floating particles
        function createParticles() {
            const particles = document.querySelector('.particles');
            const particleCount = 20;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 15 + 's';
                particle.style.animationDuration = (15 + Math.random() * 10) + 's';
                particles.appendChild(particle);
            }
        }

        // Password toggle functionality
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordToggle = document.getElementById('passwordToggle');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggle.classList.remove('fa-eye');
                passwordToggle.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordToggle.classList.remove('fa-eye-slash');
                passwordToggle.classList.add('fa-eye');
            }
        }

        // Form submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = document.querySelector('.btn-login');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const loginText = document.getElementById('loginText');

            // Show loading state
            submitBtn.disabled = true;
            loadingSpinner.style.display = 'inline-block';
            loginText.textContent = '{{ __("admin.signing_in") }}';

            fetch('{{ route("admin.login") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                } else {
                    showAlert('danger', data.message);

                    // Shake form on error
                    const formControls = document.querySelectorAll('.form-control');
                    formControls.forEach(control => {
                        control.classList.add('error');
                        setTimeout(() => control.classList.remove('error'), 500);
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('danger', 'An error occurred. Please try again.');
            })
            .finally(() => {
                // Reset loading state
                submitBtn.disabled = false;
                loadingSpinner.style.display = 'none';
                loginText.textContent = '{{ __("admin.sign_in") }}';
            });
        });

        // Alert helper
        function showAlert(type, message) {
            const alertContainer = document.getElementById('alertContainer');
            alertContainer.innerHTML = `
                <div class="alert alert-${type}">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                    ${message}
                </div>
            `;

            setTimeout(() => {
                const alert = alertContainer.querySelector('.alert');
                if (alert) {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                }
            }, 5000);
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();

            // Focus first input
            document.getElementById('email').focus();

            // Handle Enter key
            document.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    document.getElementById('loginForm').dispatchEvent(new Event('submit'));
                }
            });
        });
    </script>
</body>
</html>