<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Alenwan - منصة البث الأولى للمحتوى العربي والعالمي') }}</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('logo-alenwan.jpeg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            font-family: 'Cairo', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0a0a0a;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        .navbar {
            background: rgba(10, 10, 10, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            padding: 0;
        }

        .navbar-brand img {
            height: 50px;
            width: auto;
            object-fit: contain;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #A20136 !important;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(180deg, rgba(10, 10, 10, 0.7) 0%, rgba(10, 10, 10, 0.95) 100%),
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><rect fill="%23141414" width="1200" height="600"/></svg>');
            background-size: cover;
            background-position: center;
            padding: 120px 0 80px;
            text-align: center;
            position: relative;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #ffffff 0%, #A20136 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: none;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            font-weight: 400;
            margin-bottom: 2.5rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .cta-button {
            display: inline-block;
            padding: 16px 48px;
            background: #A20136;
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(162, 1, 54, 0.3);
            border: none;
        }

        .cta-button:hover {
            background: #6B0024;
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(162, 1, 54, 0.5);
            color: #ffffff;
        }

        /* Features Section */
        .features-section {
            background: #141414;
            padding: 80px 0;
        }

        .feature-card {
            background: #1f1f1f;
            border-radius: 12px;
            padding: 40px 30px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            background: #252525;
            border-color: #A20136;
            box-shadow: 0 12px 40px rgba(162, 1, 54, 0.2);
        }

        .feature-icon {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #A20136 0%, #A20136 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #ffffff;
        }

        .feature-description {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Footer */
        footer {
            background: #0f0f0f;
            color: #ffffff;
            padding: 60px 0 30px;
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        footer a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        footer a:hover {
            color: #A20136;
        }

        .footer-section {
            margin-bottom: 40px;
        }

        .footer-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer-tagline {
            font-size: 1rem;
            font-weight: 600;
            color: #A20136;
            margin-bottom: 1rem;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #1f1f1f;
            margin: 0 6px 6px 0;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .social-icons a:hover {
            background: #A20136;
            border-color: #A20136;
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(162, 1, 54, 0.4);
        }

        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 25px;
            margin-top: 30px;
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-subtitle {
                font-size: 1.1rem;
            }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('logo-alenwan.jpeg') }}" alt="ألوان - Alenwan">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Navigation items can be added here -->
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">{{ __('منصة البث الأولى للمحتوى العربي والعالمي') }}</h1>
            <p class="hero-subtitle">{{ __('استمتع بآلاف الأفلام والمسلسلات والبرامج الحصرية بجودة عالية') }}</p>
            <a href="#features" class="cta-button">
                {{ __('اكتشف المزيد') }}
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-film"></i>
                    </div>
                    <h3 class="feature-title">{{ __('أفلام ومسلسلات') }}</h3>
                    <p class="feature-description">{{ __('مكتبة ضخمة من الأفلام والمسلسلات العربية والعالمية بجودة عالية') }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-futbol"></i>
                    </div>
                    <h3 class="feature-title">{{ __('البث المباشر') }}</h3>
                    <p class="feature-description">{{ __('شاهد المباريات والفعاليات الرياضية والبرامج المباشرة') }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="feature-title">{{ __('وثائقيات وبودكاست') }}</h3>
                    <p class="feature-description">{{ __('محتوى تعليمي وترفيهي متنوع من وثائقيات وبودكاست حصرية') }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-child"></i>
                    </div>
                    <h3 class="feature-title">{{ __('محتوى عائلي') }}</h3>
                    <p class="feature-description">{{ __('برامج وأفلام كرتونية آمنة للأطفال والعائلة') }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3 class="feature-title">{{ __('تطبيق متعدد المنصات') }}</h3>
                    <p class="feature-description">{{ __('شاهد على أي جهاز - موبايل، تابلت، أو كمبيوتر') }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-download"></i>
                    </div>
                    <h3 class="feature-title">{{ __('مشاهدة بدون انترنت') }}</h3>
                    <p class="feature-description">{{ __('حمّل المحتوى المفضل لديك وشاهده في أي وقت') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <!-- About Section -->
                <div class="col-md-4 footer-section">
                    <h4 class="footer-title">{{ __('ألوان') }}</h4>
                    <p class="footer-tagline">{{ __('منصة البث الأولى للمحتوى العربي والعالمي') }}</p>
                    <p style="color: rgba(255, 255, 255, 0.6); font-size: 0.95rem;">{{ __('استمتع بمشاهدة آلاف الأفلام والمسلسلات والبرامج الحصرية بجودة عالية ومحتوى متنوع يناسب جميع أفراد العائلة.') }}</p>
                    <div class="social-icons mt-3">
                        <a href="#" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="#" target="_blank" title="TikTok"><i class="fab fa-tiktok"></i></a>
                        <a href="#" target="_blank" title="Snapchat"><i class="fab fa-snapchat"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-md-4 footer-section">
                    <h4 class="footer-title">{{ __('روابط سريعة') }}</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}"><i class="fas fa-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} me-2"></i>{{ __('الرئيسية') }}</a></li>
                        <li><a href="{{ route('page.show', 'about-us') }}"><i class="fas fa-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} me-2"></i>{{ __('من نحن') }}</a></li>
                        <li><a href="{{ route('page.show', 'features') }}"><i class="fas fa-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} me-2"></i>{{ __('الميزات') }}</a></li>
                        <li><a href="{{ route('page.show', 'pricing') }}"><i class="fas fa-angle-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} me-2"></i>{{ __('الأسعار') }}</a></li>
                    </ul>
                </div>

                <!-- Support Links -->
                <div class="col-md-4 footer-section">
                    <h4 class="footer-title">{{ __('الدعم والمساعدة') }}</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('page.show', 'support') }}"><i class="fas fa-headset me-2"></i>{{ __('مركز المساعدة') }}</a></li>
                        <li><a href="{{ route('page.show', 'faq') }}"><i class="fas fa-comments me-2"></i>{{ __('الأسئلة الشائعة') }}</a></li>
                        <li><a href="{{ route('page.show', 'contact-us') }}"><i class="fas fa-envelope me-2"></i>{{ __('اتصل بنا') }}</a></li>
                        <li><a href="{{ route('page.show', 'terms-conditions') }}"><i class="fas fa-file-contract me-2"></i>{{ __('الشروط والأحكام') }}</a></li>
                        <li><a href="{{ route('page.show', 'privacy-policy') }}"><i class="fas fa-shield-alt me-2"></i>{{ __('سياسة الخصوصية') }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="copyright">
                <p>&copy; {{ date('Y') }} Alenwan. {{ __('جميع الحقوق محفوظة') }}.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
