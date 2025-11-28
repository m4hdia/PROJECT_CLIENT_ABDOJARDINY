<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description', __('meta.description'))">
    <meta name="keywords" content="@yield('keywords', __('meta.keywords'))">
    
    <title>@yield('title', __('meta.title'))</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/brands.min.css">
    
    <!-- Premium Typography - Supports Arabic -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lightbox2 for Gallery -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Dark Mode Colors (Primary) */
            --dark-bg: #0a0e0b;
            --dark-surface: #111714;
            --dark-surface-elevated: #1a211c;
            --dark-border: rgba(255, 255, 255, 0.08);
            --dark-text-primary: #e8ebe9;
            --dark-text-secondary: #a8b5b1;
            
            /* Deep Green Palette */
            --deep-green: #0f2d15;
            --charcoal: #1a211c;
            --graphite: #252e27;
            --accent-green: #4ade80;
            --warm-accent: #d4a574;
            
            /* Light Mode Colors */
            --light-bg: #fafaf8;
            --light-surface: #ffffff;
            --light-surface-elevated: #f5f5f3;
            --light-border: rgba(0, 0, 0, 0.08);
            --light-text-primary: #0a0e0b;
            --light-text-secondary: #4a5551;
        }

        body {
            font-family: {{ app()->getLocale() === 'ar' ? "'Cairo', sans-serif" : "'Inter', sans-serif" }};
            overflow-x: hidden;
            direction: {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }};
            background-color: var(--dark-bg);
            color: var(--dark-text-primary);
            transition: background-color 0.4s ease, color 0.4s ease;
        }

        body.light {
            background-color: var(--light-bg);
            color: var(--light-text-primary);
        }

        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.35rem 1rem;
            border-radius: 999px;
            font-size: 0.75rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            background: rgba(74, 222, 128, 0.15);
            color: var(--accent-green);
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.95rem 2.4rem;
            border-radius: 999px;
            font-weight: 600;
            background: linear-gradient(135deg, var(--accent-green), #22c55e);
            color: var(--dark-bg);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 18px 32px rgba(74, 222, 128, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 40px rgba(74, 222, 128, 0.35);
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.95rem 2.2rem;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: inherit;
            transition: border-color 0.3s ease, color 0.3s ease;
        }

        .btn-ghost:hover {
            border-color: var(--accent-green);
            color: var(--accent-green);
        }

        .metric-pill {
            display: inline-flex;
            flex-direction: column;
            align-items: flex-start;
            border-radius: 999px;
            padding: 1rem 1.5rem;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .metric-pill span {
            font-size: 1.5rem;
            font-weight: 700;
        }

        /* Premium Typography */
        h1, h2, h3, h4, h5, h6 {
            font-family: {{ app()->getLocale() === 'ar' ? "'Cairo', sans-serif" : "'Playfair Display', serif" }};
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        [dir="rtl"] {
            direction: rtl;
        }

        [dir="ltr"] {
            direction: ltr;
        }

        /* Premium Animated Logo Preloader */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: linear-gradient(135deg, var(--deep-green) 0%, var(--charcoal) 50%, var(--graphite) 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            opacity: 1;
            transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #preloader.fade-out {
            opacity: 0;
            pointer-events: none;
        }

        .logo-reveal {
            position: relative;
            width: 200px;
            height: 200px;
        }

        .logo-circle {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 4px solid transparent;
            border-top-color: var(--accent-green);
            border-right-color: var(--warm-accent);
            animation: logo-spin 2s cubic-bezier(0.4, 0, 0.2, 1) infinite;
        }

        .logo-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 4rem;
            color: var(--accent-green);
            opacity: 0;
            animation: logo-fade-in 1s ease 0.5s forwards;
        }

        .logo-text {
            position: absolute;
            bottom: -60px;
            left: 50%;
            transform: translateX(-50%);
            font-family: {{ app()->getLocale() === 'ar' ? "'Cairo', sans-serif" : "'Playfair Display', serif" }};
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-text-primary);
            opacity: 0;
            letter-spacing: 0.1em;
            animation: logo-slide-up 1s ease 1s forwards;
            white-space: nowrap;
        }

        @keyframes logo-spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes logo-fade-in {
            from { opacity: 0; transform: translate(-50%, -50%) scale(0.8); }
            to { opacity: 1; transform: translate(-50%, -50%) scale(1); }
        }

        @keyframes logo-slide-up {
            from { opacity: 0; transform: translateX(-50%) translateY(20px); }
            to { opacity: 1; transform: translateX(-50%) translateY(0); }
        }

        /* Skip Preloader Button */
        .skip-preloader {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: var(--dark-text-primary);
            font-size: 0.875rem;
            cursor: pointer;
            opacity: 0;
            animation: fade-in 1s ease 2s forwards;
            transition: all 0.3s ease;
        }

        .skip-preloader:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(-50%) translateY(-2px);
        }

        @keyframes fade-in {
            to { opacity: 1; }
        }

        /* Navigation - Premium Dark */
        .navbar {
            background: rgba(10, 14, 11, 0.85);
            backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid var(--dark-border);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        body.light .navbar {
            background: rgba(250, 250, 248, 0.85);
            border-bottom: 1px solid var(--light-border);
        }

        .navbar.scrolled {
            padding: 0.75rem 0;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
            padding: 8px 0;
            color: var(--dark-text-secondary);
            font-weight: 500;
            font-size: 0.95rem;
        }

        body.light .nav-link {
            color: var(--light-text-secondary);
        }

        .nav-link:hover {
            color: var(--accent-green);
            transform: translateY(-2px);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            {{ app()->getLocale() === 'ar' ? 'right: 0;' : 'left: 50%;' }}
            {{ app()->getLocale() === 'ar' ? '' : 'transform: translateX(-50%);' }}
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent-green), var(--warm-accent));
            transition: all 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        /* Dark Mode Toggle */
        .dark-mode-toggle {
            width: 56px;
            height: 28px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            position: relative;
            cursor: pointer;
            border: 1px solid var(--dark-border);
            transition: all 0.3s ease;
        }

        body.light .dark-mode-toggle {
            background: rgba(0, 0, 0, 0.1);
            border-color: var(--light-border);
        }

        .dark-mode-toggle:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .dark-mode-toggle-slider {
            width: 24px;
            height: 24px;
            background: var(--accent-green);
            border-radius: 50%;
            position: absolute;
            top: 2px;
            left: 2px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        body.light .dark-mode-toggle-slider {
            left: 30px;
            background: var(--warm-accent);
        }

        .dark-mode-toggle i {
            font-size: 0.75rem;
            color: var(--dark-bg);
        }

        /* Language Switcher */
        .lang-switcher {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .lang-btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid var(--dark-border);
            background: rgba(255, 255, 255, 0.05);
            color: var(--dark-text-secondary);
            font-size: 0.875rem;
        }

        body.light .lang-btn {
            border-color: var(--light-border);
            background: rgba(0, 0, 0, 0.05);
            color: var(--light-text-secondary);
        }

        .lang-btn.active {
            background: var(--accent-green);
            color: var(--dark-bg);
            border-color: var(--accent-green);
        }

        body.light .lang-btn.active {
            color: white;
        }

        .lang-btn:not(.active):hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--accent-green);
        }

        /* Service Cards - Premium */
        .service-card {
            background: var(--dark-surface-elevated);
            border: 1px solid var(--dark-border);
            border-radius: 20px;
            padding: 2.5rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            height: 100%;
            backdrop-filter: blur(10px);
        }

        body.light .service-card {
            background: var(--light-surface);
            border-color: var(--light-border);
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(74, 222, 128, 0.1), rgba(212, 165, 116, 0.1));
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .service-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 24px 48px rgba(74, 222, 128, 0.2);
            border-color: var(--accent-green);
        }

        body.light .service-card:hover {
            box-shadow: 0 24px 48px rgba(0, 0, 0, 0.15);
        }

        .service-card:hover::before {
            opacity: 1;
        }

        /* Scroll Animations */
        .fade-in-up {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform, opacity;
        }

        .fade-in-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Respect Reduced Motion */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Mobile Menu */
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--dark-surface-elevated);
            border-top: 1px solid var(--dark-border);
        }

        body.light .mobile-menu {
            background: var(--light-surface);
            border-top-color: var(--light-border);
        }

        .mobile-menu.active {
            max-height: 600px;
        }

        /* Portfolio Gallery */
        .portfolio-item {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            cursor: pointer;
            height: 300px;
            border: 1px solid var(--dark-border);
        }

        body.light .portfolio-item {
            border-color: var(--light-border);
        }

        .portfolio-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
        }

        .portfolio-item:hover img {
            transform: scale(1.1);
        }

        .portfolio-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(10, 14, 11, 0.9), rgba(26, 33, 28, 0.9));
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .portfolio-item:hover .portfolio-overlay {
            opacity: 1;
        }

        /* WhatsApp Button */
        .whatsapp-btn {
            background: #25D366;
            transition: all 0.3s ease;
        }

        .whatsapp-btn:hover {
            background: #128C7E;
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 24px rgba(37, 211, 102, 0.4);
        }

        /* Floating WhatsApp Button */
        .floating-whatsapp {
            position: fixed;
            bottom: 24px;
            {{ app()->getLocale() === 'ar' ? 'left: 24px;' : 'right: 24px;' }}
            width: 64px;
            height: 64px;
            background: #25D366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(37, 211, 102, 0.4);
            z-index: 999;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .floating-whatsapp:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 32px rgba(37, 211, 102, 0.5);
        }

        .floating-whatsapp i {
            font-size: 2rem;
            color: white;
        }

        /* Before/After Slider */
        .before-after-container {
            position: relative;
            width: 100%;
            height: 500px;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--dark-border);
        }

        body.light .before-after-container {
            border-color: var(--light-border);
        }

        .before-after-slider {
            position: absolute;
            top: 0;
            left: 50%;
            width: 4px;
            height: 100%;
            background: white;
            cursor: ew-resize;
            z-index: 10;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        .before-after-slider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 48px;
            height: 48px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .before-after-slider::after {
            content: 'âŸ·';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.5rem;
            color: var(--dark-bg);
        }

        /* Glass/Blur Effect */
        .glass-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        body.light .glass-panel {
            background: rgba(255, 255, 255, 0.8);
            border-color: rgba(0, 0, 0, 0.1);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Premium Animated Logo Preloader -->
    @if(request()->routeIs('home'))
    <div id="preloader">
        <div class="logo-reveal">
            <div class="logo-circle"></div>
            <div class="logo-icon">
                <i class="fas fa-leaf"></i>
            </div>
        </div>
        <div class="logo-text" id="logo-text">{{ __('meta.site_name') }}</div>
        <button class="skip-preloader" onclick="skipPreloader()">{{ __('preloader.skip') }}</button>
    </div>
    @endif

    <!-- Main Content -->
    <div id="main-content" @if(request()->routeIs('home')) style="display: none;" @endif>
        @include('partials.navbar')
        
        @yield('content')
        
        @include('partials.footer')
        
        <!-- Floating WhatsApp Button -->
        <a href="https://wa.me/33123456789?text={{ urlencode(__('whatsapp.contact')) }}" target="_blank" class="floating-whatsapp" aria-label="{{ __('whatsapp.contact') }}">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
    
    <script>
        // Premium Preloader
        @if(request()->routeIs('home'))
        function skipPreloader() {
            const preloader = document.getElementById('preloader');
            const mainContent = document.getElementById('main-content');
            
            if (preloader) {
                preloader.classList.add('fade-out');
                if (mainContent) mainContent.style.display = 'block';
                
                setTimeout(function() {
                    if (preloader) preloader.style.display = 'none';
                    if (mainContent) mainContent.style.opacity = '1';
                }, 800);
            }
        }

        window.addEventListener('load', function() {
            setTimeout(function() {
                skipPreloader();
            }, 2500); // Show for 2.5 seconds minimum
        });
        @endif

        // Dark Mode Toggle
        function initDarkMode() {
            const savedMode = localStorage.getItem('darkMode');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (savedMode === null) {
                // Default to dark mode
                document.body.classList.add('dark');
                localStorage.setItem('darkMode', 'dark');
            } else if (savedMode === 'light') {
                document.body.classList.remove('dark');
                document.body.classList.add('light');
            } else {
                document.body.classList.remove('light');
                document.body.classList.add('dark');
            }
        }

        function toggleDarkMode() {
            const body = document.body;
            const darkIcon = document.getElementById('dark-icon');
            const lightIcon = document.getElementById('light-icon');
            const darkIconMobile = document.getElementById('dark-icon-mobile');
            const lightIconMobile = document.getElementById('light-icon-mobile');
            
            if (body.classList.contains('dark')) {
                body.classList.remove('dark');
                body.classList.add('light');
                localStorage.setItem('darkMode', 'light');
                if (darkIcon) darkIcon.style.display = 'none';
                if (lightIcon) lightIcon.style.display = 'block';
                if (darkIconMobile) darkIconMobile.style.display = 'none';
                if (lightIconMobile) lightIconMobile.style.display = 'block';
            } else {
                body.classList.remove('light');
                body.classList.add('dark');
                localStorage.setItem('darkMode', 'dark');
                if (darkIcon) darkIcon.style.display = 'block';
                if (lightIcon) lightIcon.style.display = 'none';
                if (darkIconMobile) darkIconMobile.style.display = 'block';
                if (lightIconMobile) lightIconMobile.style.display = 'none';
            }
        }
        
        // Update icon on page load
        function updateDarkModeIcon() {
            const body = document.body;
            const darkIcon = document.getElementById('dark-icon');
            const lightIcon = document.getElementById('light-icon');
            const darkIconMobile = document.getElementById('dark-icon-mobile');
            const lightIconMobile = document.getElementById('light-icon-mobile');
            
            if (body.classList.contains('dark')) {
                if (darkIcon) darkIcon.style.display = 'block';
                if (lightIcon) lightIcon.style.display = 'none';
                if (darkIconMobile) darkIconMobile.style.display = 'block';
                if (lightIconMobile) lightIconMobile.style.display = 'none';
            } else {
                if (darkIcon) darkIcon.style.display = 'none';
                if (lightIcon) lightIcon.style.display = 'block';
                if (darkIconMobile) darkIconMobile.style.display = 'none';
                if (lightIconMobile) lightIconMobile.style.display = 'block';
            }
        }
        
        // Update icon after initialization
        setTimeout(updateDarkModeIcon, 100);

        // Initialize dark mode on load
        initDarkMode();

        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (navbar) {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }
        });

        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileMenu) {
                mobileMenu.classList.toggle('active');
            }
        }

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href.length > 1) {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        const mobileMenu = document.getElementById('mobile-menu');
                        if (mobileMenu) mobileMenu.classList.remove('active');
                    }
                }
            });
        });

        // Scroll Animations with Intersection Observer
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver(
            function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            },
            observerOptions
        );

        document.querySelectorAll('.fade-in-up').forEach(el => observer.observe(el));

        // Parallax Effect for Hero
        function initParallax() {
            const hero = document.querySelector('.hero-parallax');
            if (hero && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                window.addEventListener('scroll', function() {
                    const scrolled = window.pageYOffset;
                    const rate = scrolled * 0.5;
                    hero.style.transform = `translateY(${rate}px)`;
                });
            }
        }

        initParallax();
    </script>
    
    @stack('scripts')
</body>
</html>

