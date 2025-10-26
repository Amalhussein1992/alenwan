<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alenwan - Premium Streaming Experience</title>

    <!-- Bootstrap CSS -->
    @if(app()->getLocale() === 'ar')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #a20136;
            --primary-gradient: linear-gradient(135deg, #a20136 0%, #d4154e 100%);
            --secondary-color: #d4154e;
            --accent-color: #10b981;
            --dark-color: #1a1a1a;
            --light-color: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-600: #4b5563;
            --gray-800: #1f2937;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark-color);
            color: var(--light-color);
            overflow-x: hidden;
        }

        body[dir="rtl"] {
            font-family: 'Cairo', sans-serif;
        }

        /* Navigation */
        .navbar {
            background: rgba(26, 26, 26, 0.95);
            backdrop-filter: blur(20px);
            padding: 1rem 0;
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar.scrolled {
            background: rgba(26, 26, 26, 0.98);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            margin: 0 1rem;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-color) !important;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #a20136 0%, #d4154e 50%, #1a1a1a 100%);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="grad" cx="50%" cy="50%" r="50%"><stop offset="0%" style="stop-color:%23667eea;stop-opacity:0.1"/><stop offset="100%" style="stop-color:%23764ba2;stop-opacity:0"/></radialGradient></defs><circle cx="500" cy="500" r="500" fill="url(%23grad)"/></svg>');
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-20px, -20px) scale(1.1); }
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .btn-hero {
            background: var(--primary-gradient);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            margin-right: 1rem;
            margin-bottom: 1rem;
        }

        [dir="rtl"] .btn-hero {
            margin-right: 0;
            margin-left: 1rem;
        }

        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 1rem 2rem;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
            color: white;
        }

        /* Features Section */
        .features {
            padding: 8rem 0;
            background: linear-gradient(to bottom, var(--dark-color) 0%, #2a2a2a 100%);
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 2rem;
            padding: 3rem 2rem;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2rem;
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: white;
        }

        .feature-description {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
        }

        /* Statistics Section */
        .stats {
            padding: 6rem 0;
            background: var(--primary-gradient);
        }

        .stat-item {
            text-align: center;
            padding: 2rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: white;
            margin-bottom: 0.5rem;
            display: block;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Content Preview */
        .content-preview {
            padding: 8rem 0;
            background: #2a2a2a;
        }

        .movie-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .movie-card:hover {
            transform: scale(1.05);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .movie-poster {
            height: 300px;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            position: relative;
            overflow: hidden;
        }

        .movie-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .movie-card:hover .movie-overlay {
            opacity: 1;
        }

        .play-button {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-color);
            font-size: 1.5rem;
        }

        .movie-info {
            padding: 1.5rem;
        }

        .movie-title {
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: white;
        }

        .movie-meta {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        /* Pricing Section */
        .pricing {
            padding: 8rem 0;
            background: var(--dark-color);
        }

        .pricing-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 2rem;
            padding: 3rem 2rem;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
        }

        .pricing-card.popular {
            transform: scale(1.05);
            background: rgba(102, 126, 234, 0.1);
            border-color: var(--primary-color);
        }

        .pricing-card.popular::before {
            content: attr(data-popular-text);
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--primary-gradient);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.1);
        }

        .pricing-card.popular:hover {
            transform: translateY(-10px) scale(1.05);
        }

        .price {
            font-size: 3rem;
            font-weight: 800;
            color: white;
            margin-bottom: 0.5rem;
        }

        .price-period {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 2rem;
        }

        .feature-list {
            list-style: none;
            margin-bottom: 2rem;
        }

        .feature-list li {
            padding: 0.5rem 0;
            color: rgba(255, 255, 255, 0.8);
        }

        .feature-list i {
            color: var(--accent-color);
            margin-right: 0.5rem;
        }

        [dir="rtl"] .feature-list i {
            margin-right: 0;
            margin-left: 0.5rem;
        }

        /* Footer */
        .footer {
            background: #0f0f0f;
            padding: 4rem 0 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-section h5 {
            color: white;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .footer-section a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: var(--primary-color);
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-link {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            margin-top: 3rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .features,
            .content-preview,
            .pricing {
                padding: 4rem 0;
            }

            .pricing-card.popular {
                transform: none;
                margin-top: 2rem;
            }
        }

        /* Animation Classes */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .fade-up.aos-animate {
            opacity: 1;
            transform: translateY(0);
        }

        .fade-in {
            opacity: 0;
            transition: opacity 0.6s ease;
        }

        .fade-in.aos-animate {
            opacity: 1;
        }

        /* Dropdown hover styles */
        .dropdown-item:hover {
            background: var(--primary-color) !important;
            color: white !important;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#home">
                <i class="fas fa-play-circle me-2"></i>Alenwan
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">{{ __('landing.home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">{{ __('landing.features') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#content">{{ __('landing.content') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">{{ __('landing.pricing') }}</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <div class="dropdown me-3">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-globe me-1"></i>
                            @if(app()->getLocale() === 'ar')
                                العربية
                            @elseif(app()->getLocale() === 'fr')
                                Français
                            @elseif(app()->getLocale() === 'es')
                                Español
                            @else
                                English
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown" style="background: rgba(26, 26, 26, 0.95); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1);">
                            <li><a class="dropdown-item" href="?lang=en" style="color: rgba(255, 255, 255, 0.8);">English</a></li>
                            <li><a class="dropdown-item" href="?lang=ar" style="color: rgba(255, 255, 255, 0.8);">العربية</a></li>
                            <li><a class="dropdown-item" href="?lang=fr" style="color: rgba(255, 255, 255, 0.8);">Français</a></li>
                            <li><a class="dropdown-item" href="?lang=es" style="color: rgba(255, 255, 255, 0.8);">Español</a></li>
                        </ul>
                    </div>
                    <a href="#" class="btn btn-outline-light me-2">{{ __('landing.sign_in') }}</a>
                    <a href="#" class="btn btn-primary">{{ __('landing.get_started') }}</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
                        <h1>{{ __('landing.hero_title') }}</h1>
                        <p>{{ __('landing.hero_subtitle') }}</p>
                        <div>
                            <a href="#" class="btn-hero">
                                <i class="fas fa-play"></i>
                                {{ __('landing.start_watching') }}
                            </a>
                            <a href="#features" class="btn-secondary">
                                <i class="fas fa-info-circle"></i>
                                {{ __('landing.learn_more') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                        <!-- Hero image or video placeholder -->
                        <div style="width: 100%; height: 400px; background: rgba(255,255,255,0.1); border-radius: 2rem; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                            <i class="fas fa-play-circle" style="font-size: 6rem; color: rgba(255,255,255,0.8);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics -->
    <section class="stats">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="stat-item" data-aos="fade-up" data-aos-duration="800">
                        <span class="stat-number">10K+</span>
                        <div class="stat-label">{{ __('landing.stat_movies') }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                        <span class="stat-number">5M+</span>
                        <div class="stat-label">{{ __('landing.stat_users') }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                        <span class="stat-number">4K</span>
                        <div class="stat-label">{{ __('landing.stat_quality') }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                        <span class="stat-number">24/7</span>
                        <div class="stat-label">{{ __('landing.stat_support') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="mb-4" data-aos="fade-up" style="font-size: 3rem; font-weight: 800;">{{ __('landing.why_choose') }}</h2>
                    <p class="lead" data-aos="fade-up" data-aos-delay="100" style="color: rgba(255,255,255,0.8);">{{ __('landing.why_subtitle') }}</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card" data-aos="fade-up" data-aos-duration="800">
                        <div class="feature-icon">
                            <i class="fas fa-video"></i>
                        </div>
                        <h3 class="feature-title">{{ __('landing.feature_4k_title') }}</h3>
                        <p class="feature-description">{{ __('landing.feature_4k_desc') }}</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                        <div class="feature-icon">
                            <i class="fas fa-download"></i>
                        </div>
                        <h3 class="feature-title">{{ __('landing.feature_downloads_title') }}</h3>
                        <p class="feature-description">{{ __('landing.feature_downloads_desc') }}</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                        <div class="feature-icon">
                            <i class="fas fa-devices"></i>
                        </div>
                        <h3 class="feature-title">{{ __('landing.feature_multidevice_title') }}</h3>
                        <p class="feature-description">{{ __('landing.feature_multidevice_desc') }}</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                        <div class="feature-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h3 class="feature-title">{{ __('landing.feature_global_title') }}</h3>
                        <p class="feature-description">{{ __('landing.feature_global_desc') }}</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                        <div class="feature-icon">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <h3 class="feature-title">{{ __('landing.feature_family_title') }}</h3>
                        <p class="feature-description">{{ __('landing.feature_family_desc') }}</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="feature-title">{{ __('landing.feature_secure_title') }}</h3>
                        <p class="feature-description">{{ __('landing.feature_secure_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Preview -->
    <section id="content" class="content-preview">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="mb-4" data-aos="fade-up" style="font-size: 3rem; font-weight: 800;">{{ __('landing.featured_content') }}</h2>
                    <p class="lead" data-aos="fade-up" data-aos-delay="100" style="color: rgba(255,255,255,0.8);">{{ __('landing.featured_subtitle') }}</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="movie-card" data-aos="fade-up" data-aos-duration="800">
                        <div class="movie-poster">
                            <div class="movie-overlay">
                                <div class="play-button">
                                    <i class="fas fa-play"></i>
                                </div>
                            </div>
                        </div>
                        <div class="movie-info">
                            <h4 class="movie-title">{{ __('landing.movie_action') }}</h4>
                            <p class="movie-meta">{{ __('landing.movie_action_meta') }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="movie-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                        <div class="movie-poster">
                            <div class="movie-overlay">
                                <div class="play-button">
                                    <i class="fas fa-play"></i>
                                </div>
                            </div>
                        </div>
                        <div class="movie-info">
                            <h4 class="movie-title">{{ __('landing.movie_scifi') }}</h4>
                            <p class="movie-meta">{{ __('landing.movie_scifi_meta') }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="movie-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                        <div class="movie-poster">
                            <div class="movie-overlay">
                                <div class="play-button">
                                    <i class="fas fa-play"></i>
                                </div>
                            </div>
                        </div>
                        <div class="movie-info">
                            <h4 class="movie-title">{{ __('landing.movie_comedy') }}</h4>
                            <p class="movie-meta">{{ __('landing.movie_comedy_meta') }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="movie-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                        <div class="movie-poster">
                            <div class="movie-overlay">
                                <div class="play-button">
                                    <i class="fas fa-play"></i>
                                </div>
                            </div>
                        </div>
                        <div class="movie-info">
                            <h4 class="movie-title">{{ __('landing.movie_drama') }}</h4>
                            <p class="movie-meta">{{ __('landing.movie_drama_meta') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="pricing">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="mb-4" data-aos="fade-up" style="font-size: 3rem; font-weight: 800;">{{ __('landing.choose_plan') }}</h2>
                    <p class="lead" data-aos="fade-up" data-aos-delay="100" style="color: rgba(255,255,255,0.8);">{{ __('landing.pricing_subtitle') }}</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card" data-aos="fade-up" data-aos-duration="800">
                        <h3 style="color: white; margin-bottom: 1rem;">{{ __('landing.plan_basic') }}</h3>
                        <div class="price">$9.99</div>
                        <div class="price-period">{{ __('landing.per_month') }}</div>
                        <ul class="feature-list">
                            <li><i class="fas fa-check"></i> {{ __('landing.basic_feature_1') }}</li>
                            <li><i class="fas fa-check"></i> {{ __('landing.basic_feature_2') }}</li>
                            <li><i class="fas fa-check"></i> {{ __('landing.basic_feature_3') }}</li>
                            <li><i class="fas fa-check"></i> {{ __('landing.basic_feature_4') }}</li>
                        </ul>
                        <a href="#" class="btn-hero w-100">{{ __('landing.get_started') }}</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card popular" data-popular-text="{{ __('landing.most_popular') }}" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                        <h3 style="color: white; margin-bottom: 1rem;">{{ __('landing.plan_premium') }}</h3>
                        <div class="price">$15.99</div>
                        <div class="price-period">{{ __('landing.per_month') }}</div>
                        <ul class="feature-list">
                            <li><i class="fas fa-check"></i> {{ __('landing.premium_feature_1') }}</li>
                            <li><i class="fas fa-check"></i> {{ __('landing.premium_feature_2') }}</li>
                            <li><i class="fas fa-check"></i> {{ __('landing.premium_feature_3') }}</li>
                            <li><i class="fas fa-check"></i> {{ __('landing.premium_feature_4') }}</li>
                            <li><i class="fas fa-check"></i> {{ __('landing.premium_feature_5') }}</li>
                        </ul>
                        <a href="#" class="btn-hero w-100">{{ __('landing.get_started') }}</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mx-auto">
                    <div class="pricing-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                        <h3 style="color: white; margin-bottom: 1rem;">{{ __('landing.plan_enterprise') }}</h3>
                        <div class="price">$29.99</div>
                        <div class="price-period">{{ __('landing.per_month') }}</div>
                        <ul class="feature-list">
                            <li><i class="fas fa-check"></i> {{ __('landing.enterprise_feature_1') }}</li>
                            <li><i class="fas fa-check"></i> {{ __('landing.enterprise_feature_2') }}</li>
                            <li><i class="fas fa-check"></i> {{ __('landing.enterprise_feature_3') }}</li>
                            <li><i class="fas fa-check"></i> {{ __('landing.enterprise_feature_4') }}</li>
                            <li><i class="fas fa-check"></i> {{ __('landing.enterprise_feature_5') }}</li>
                        </ul>
                        <a href="#" class="btn-hero w-100">{{ __('landing.get_started') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5>
                        <i class="fas fa-play-circle me-2"></i>
                        Alenwan
                    </h5>
                    <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">{{ __('landing.footer_description') }}</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-section">
                        <h5>{{ __('landing.company') }}</h5>
                        <a href="#">{{ __('landing.about_us') }}</a>
                        <a href="#">{{ __('landing.careers') }}</a>
                        <a href="#">{{ __('landing.press') }}</a>
                        <a href="#">{{ __('landing.blog') }}</a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-section">
                        <h5>{{ __('landing.support') }}</h5>
                        <a href="#">{{ __('landing.help_center') }}</a>
                        <a href="#">{{ __('landing.contact_us') }}</a>
                        <a href="#">{{ __('landing.system_status') }}</a>
                        <a href="#">{{ __('landing.bug_reports') }}</a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-section">
                        <h5>{{ __('landing.legal') }}</h5>
                        <a href="#">{{ __('landing.terms') }}</a>
                        <a href="#">{{ __('landing.privacy') }}</a>
                        <a href="#">{{ __('landing.cookies') }}</a>
                        <a href="#">{{ __('landing.dmca') }}</a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-section">
                        <h5>{{ __('landing.download') }}</h5>
                        <a href="#"><i class="fab fa-apple me-2"></i>{{ __('landing.ios_app') }}</a>
                        <a href="#"><i class="fab fa-android me-2"></i>{{ __('landing.android_app') }}</a>
                        <a href="#"><i class="fab fa-windows me-2"></i>{{ __('landing.windows_app') }}</a>
                        <a href="#"><i class="fab fa-app-store me-2"></i>{{ __('landing.mac_app') }}</a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2024 Alenwan. {{ __('landing.rights_reserved') }} | <a href="{{ route('admin.dashboard') }}" style="color: var(--primary-color);">{{ __('landing.admin_panel') }}</a></p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNav');
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Counter animation for statistics
        function animateCounter(element, start, end, duration) {
            let current = start;
            const increment = (end - start) / (duration / 16);
            const timer = setInterval(() => {
                current += increment;
                element.textContent = Math.floor(current);
                if (current >= end) {
                    clearInterval(timer);
                    element.textContent = end;
                }
            }, 16);
        }

        // Trigger counter animation when stats section is in view
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = entry.target.querySelectorAll('.stat-number');
                    counters.forEach(counter => {
                        const text = counter.textContent;
                        const number = parseInt(text.replace(/\D/g, ''));
                        const suffix = text.replace(/\d/g, '');
                        counter.textContent = '0' + suffix;
                        animateCounter(counter, 0, number, 2000);
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        const statsSection = document.querySelector('.stats');
        if (statsSection) {
            observer.observe(statsSection);
        }
    </script>
</body>
</html>