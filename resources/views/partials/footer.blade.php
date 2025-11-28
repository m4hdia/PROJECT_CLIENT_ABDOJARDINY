<footer class="bg-dark-surface-elevated border-t border-dark-border mt-20 text-white">
    <div class="container mx-auto px-6 py-14">
        <div class="grid gap-10 lg:grid-cols-3">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center">
                        <i class="fas fa-leaf text-white text-xl"></i>
                    </div>
                    <span class="text-2xl font-semibold">{{ __('meta.site_name') }}</span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">{{ __('footer.description') }}</p>
                <div class="flex gap-3 mt-6">
                    @foreach (['facebook-f','instagram','linkedin-in'] as $icon)
                        <a href="#" class="w-11 h-11 rounded-full border border-white/15 flex items-center justify-center hover:border-green-400 hover:text-green-400 transition">
                            <i class="fab fa-{{ $icon }}"></i>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm uppercase tracking-[0.4em] text-gray-500 mb-4">{{ __('footer.services') }}</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="{{ route('services') }}" class="hover:text-green-300">{{ __('services.item2') }}</a></li>
                        <li><a href="{{ route('services') }}" class="hover:text-green-300">{{ __('services.item1') }}</a></li>
                        <li><a href="{{ route('services') }}" class="hover:text-green-300">{{ __('services.item3') }}</a></li>
                        <li><a href="{{ route('services') }}" class="hover:text-green-300">{{ __('services.item4') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm uppercase tracking-[0.4em] text-gray-500 mb-4">{{ __('footer.links') }}</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-green-300">{{ __('nav.home') }}</a></li>
                        <li><a href="{{ route('gallery') }}" class="hover:text-green-300">{{ __('nav.gallery') }}</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-green-300">{{ __('nav.about') }}</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-green-300">{{ __('nav.contact') }}</a></li>
                    </ul>
                </div>
            </div>
            <div>
                <h4 class="text-sm uppercase tracking-[0.4em] text-gray-500 mb-4">{{ __('footer.contact') }}</h4>
                <ul class="space-y-4 text-gray-300 text-sm">
                    <li class="flex gap-3">
                        <i class="fas fa-map-marker-alt text-green-400 mt-1"></i>
                        <span>{{ __('contact.address') }}</span>
                    </li>
                    <li class="flex gap-3">
                        <i class="fas fa-phone text-green-400 mt-1"></i>
                        <a href="tel:{{ __('contact.phone') }}" class="hover:text-green-300">{{ __('contact.phone') }}</a>
                    </li>
                    <li class="flex gap-3">
                        <i class="fas fa-envelope text-green-400 mt-1"></i>
                        <a href="mailto:{{ __('contact.email') }}" class="hover:text-green-300">{{ __('contact.email') }}</a>
                    </li>
                    <li class="flex gap-3">
                        <i class="fas fa-clock text-green-400 mt-1"></i>
                        <span>{{ __('contact.hours') }}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 mt-12 pt-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between text-gray-400 text-sm">
            <div class="lang-switcher">
                <span class="mr-3">{{ __('footer.select_language') }}:</span>
                <a href="{{ route('lang.switch', 'fr') }}" class="lang-btn {{ app()->getLocale() === 'fr' ? 'active' : '' }}">FR</a>
                <a href="{{ route('lang.switch', 'ar') }}" class="lang-btn {{ app()->getLocale() === 'ar' ? 'active' : '' }}">AR</a>
            </div>
            <p>{{ __('footer.copyright') }}</p>
        </div>
    </div>
</footer>


