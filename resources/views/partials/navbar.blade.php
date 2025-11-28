<nav class="navbar">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse group">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center shadow-lg transition-transform duration-300 group-hover:scale-110">
                    <i class="fas fa-leaf text-white text-xl"></i>
                </div>
                <span class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-green-600 hidden sm:block transition-opacity duration-300 group-hover:opacity-80">
                    {{ __('meta.site_name') }}
                </span>
            </a>

            <!-- Right Controls: Language + Dark Mode (Desktop) -->
            <div class="hidden lg:flex items-center space-x-4 rtl:space-x-reverse">
                <div class="lang-switcher">
                    <a href="{{ route('lang.switch', 'fr') }}" class="lang-btn {{ app()->getLocale() === 'fr' ? 'active' : '' }}">FR</a>
                    <a href="{{ route('lang.switch', 'ar') }}" class="lang-btn {{ app()->getLocale() === 'ar' ? 'active' : '' }}">AR</a>
                </div>

                <!-- Dark Mode Toggle -->
                <button onclick="toggleDarkMode()" class="dark-mode-toggle" aria-label="Toggle dark mode">
                    <div class="dark-mode-toggle-slider">
                        <i class="fas fa-moon" id="dark-icon"></i>
                        <i class="fas fa-sun" id="light-icon" style="display: none;"></i>
                    </div>
                </button>
            </div>

            <!-- Mobile Controls -->
            <div class="flex items-center lg:hidden space-x-3 rtl:space-x-reverse">
                <div class="lang-switcher">
                    <a href="{{ route('lang.switch', 'fr') }}" class="lang-btn {{ app()->getLocale() === 'fr' ? 'active' : '' }}">FR</a>
                    <a href="{{ route('lang.switch', 'ar') }}" class="lang-btn {{ app()->getLocale() === 'ar' ? 'active' : '' }}">AR</a>
                </div>
                <button onclick="toggleDarkMode()" class="dark-mode-toggle" aria-label="Toggle dark mode">
                    <div class="dark-mode-toggle-slider">
                        <i class="fas fa-moon" id="dark-icon-mobile"></i>
                        <i class="fas fa-sun" id="light-icon-mobile" style="display: none;"></i>
                    </div>
                </button>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Additional styles for mobile controls in light mode */
    body.light .mobile-menu a {
        color: var(--light-text-secondary);
    }

    body.light .mobile-menu a:hover,
    body.light .mobile-menu a.text-green-400 {
        color: var(--accent-green);
    }
</style>
