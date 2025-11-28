@extends('layouts.main')

@section('title', __('about.title') . ' - ' . __('meta.title'))
@section('description', __('about.description'))

@section('content')
<main class="text-white bg-dark-surface">
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(74,222,128,0.15),_transparent_45%)]"></div>
        <div class="relative z-10 px-6 py-28 lg:py-36 container mx-auto grid gap-10 lg:grid-cols-[1.1fr,0.9fr]">
            <div>
                <p class="section-badge inline-flex items-center gap-2 text-sm uppercase tracking-[0.4em]">
                    <span class="w-2 h-2 rounded-full bg-green-400"></span>
                    {{ __('home.badge') }}
                </p>
                <h1 class="text-4xl md:text-6xl font-extrabold mt-6">{{ __('about.title') }}</h1>
                <p class="text-gray-300 text-lg md:text-xl mt-6 leading-relaxed">{{ __('about.description') }}</p>
                <div class="flex flex-wrap gap-4 mt-10">
                    <div class="metric-pill bg-[rgba(74,222,128,0.12)] text-green-300">
                        <span>15+</span>
                        <small>{{ __('about.stats.years') }}</small>
                    </div>
                    <div class="metric-pill bg-[rgba(255,255,255,0.08)] text-white">
                        <span>500+</span>
                        <small>{{ __('about.stats.projects') }}</small>
                    </div>
                    <div class="metric-pill bg-[rgba(37,211,102,0.12)] text-green-200">
                        <span>98%</span>
                        <small>{{ __('about.stats.clients') }}</small>
                    </div>
                </div>
            </div>
            <div class="bg-dark-surface-elevated/70 rounded-[32px] border border-white/10 p-8 backdrop-blur">
                <p class="text-sm uppercase tracking-[0.5em] text-gray-400">{{ __('home.signature.title') }}</p>
                <h3 class="text-2xl font-semibold mt-4">{{ __('nav.about') }}</h3>
                <p class="text-gray-300 mt-4">{{ __('home.signature.text') }}</p>
                <div class="mt-6 space-y-3 text-gray-400">
                    <div>• {{ __('home.signature.point1') }}</div>
                    <div>• {{ __('home.signature.point2') }}</div>
                    <div>• {{ __('home.signature.point3') }}</div>
                </div>
                <a href="{{ route('services') }}" class="btn-ghost mt-8 inline-flex items-center gap-2">
                    {{ __('nav.services') }} <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <section class="px-6 py-20 bg-dark-surface-elevated">
        <div class="container mx-auto grid gap-8 md:grid-cols-2">
            <div class="p-8 rounded-3xl border border-white/10 bg-dark-surface">
                <p class="section-badge mb-4">{{ __('services.subtitle') }}</p>
                <h2 class="text-3xl font-semibold mb-6">{{ __('home.signature.title') }}</h2>
                <p class="text-gray-400 leading-relaxed">{{ __('home.signature.text') }}</p>
                <ul class="mt-6 space-y-4 text-gray-300">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check text-green-400 mt-1"></i>
                        <span>{{ __('services.item2') }} — {{ __('services.design_desc') }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check text-green-400 mt-1"></i>
                        <span>{{ __('services.item1') }} — {{ __('services.maintenance_desc') }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check text-green-400 mt-1"></i>
                        <span>{{ __('services.item3') }} — {{ __('services.irrigation_desc') }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check text-green-400 mt-1"></i>
                        <span>{{ __('services.item4') }} — {{ __('services.planting_desc') }}</span>
                    </li>
                </ul>
            </div>
            <div class="p-8 rounded-3xl border border-white/10 bg-gradient-to-br from-dark-surface to-dark-surface-elevated">
                <h3 class="text-2xl font-semibold mb-4">{{ __('projects.modern_garden') }}</h3>
                <p class="text-gray-400">{{ __('projects.modern_garden_desc') }}</p>
                <div class="mt-8 grid gap-6 sm:grid-cols-2">
                    <div>
                        <p class="text-3xl font-bold text-green-300">24</p>
                        <p class="text-gray-400 text-sm">{{ __('services.item2') }}</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-green-300">42</p>
                        <p class="text-gray-400 text-sm">{{ __('services.item4') }}</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-green-300">1.5km</p>
                        <p class="text-gray-400 text-sm">{{ __('services.item3') }}</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-green-300">∞</p>
                        <p class="text-gray-400 text-sm">{{ __('footer.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="px-6 py-20 bg-dark-surface">
        <div class="container mx-auto">
            <div class="max-w-3xl">
                <p class="section-badge mb-4">{{ __('gallery.title') }}</p>
                <h2 class="text-3xl md:text-5xl font-semibold mb-6">{{ __('gallery.subtitle') }}</h2>
                <p class="text-gray-400">{{ __('about.description') }}</p>
            </div>
            <div class="grid gap-6 mt-12 md:grid-cols-3">
                <article class="p-6 rounded-3xl border border-white/10 bg-dark-surface-elevated">
                    <i class="fas fa-leaf text-green-400 text-3xl mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">{{ __('services.item2') }}</h3>
                    <p class="text-gray-400 text-sm">{{ __('services.design_desc') }}</p>
                </article>
                <article class="p-6 rounded-3xl border border-white/10 bg-dark-surface-elevated">
                    <i class="fas fa-water text-green-400 text-3xl mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">{{ __('services.item3') }}</h3>
                    <p class="text-gray-400 text-sm">{{ __('services.irrigation_desc') }}</p>
                </article>
                <article class="p-6 rounded-3xl border border-white/10 bg-dark-surface-elevated">
                    <i class="fas fa-seedling text-green-400 text-3xl mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">{{ __('services.item4') }}</h3>
                    <p class="text-gray-400 text-sm">{{ __('services.planting_desc') }}</p>
                </article>
            </div>
        </div>
    </section>

    <section class="px-6 py-20 bg-dark-surface-elevated">
        <div class="container mx-auto grid gap-10 lg:grid-cols-2">
            <div class="rounded-[32px] border border-white/10 p-8 bg-dark-surface">
                <p class="section-badge mb-4">{{ __('projects.traditional_courtyard') }}</p>
                <h2 class="text-3xl font-semibold mb-4">{{ __('home.projects.title') }}</h2>
                <p class="text-gray-300 leading-relaxed">{{ __('projects.traditional_courtyard_desc') }}</p>
                <ul class="mt-6 space-y-3 text-gray-400">
                    <li>• {{ __('projects.japanese_desc') }}</li>
                    <li>• {{ __('services.maintenance_desc') }}</li>
                    <li>• {{ __('services.item1') }}</li>
                </ul>
            </div>
            <div class="rounded-[32px] border border-white/10 p-8 bg-gradient-to-br from-dark-surface to-dark-surface-elevated">
                <p class="section-badge mb-4">{{ __('footer.contact') }}</p>
                <h3 class="text-2xl font-semibold mb-6">{{ __('contact.subtitle') }}</h3>
                <div class="space-y-5 text-gray-300">
                    <div class="flex gap-3">
                        <i class="fas fa-map-marker-alt text-green-400 mt-1"></i>
                        <span>{{ __('contact.address') }}</span>
                    </div>
                    <div class="flex gap-3">
                        <i class="fas fa-phone text-green-400 mt-1"></i>
                        <a href="tel:{{ __('contact.phone') }}">{{ __('contact.phone') }}</a>
                    </div>
                    <div class="flex gap-3">
                        <i class="fas fa-envelope text-green-400 mt-1"></i>
                        <a href="mailto:{{ __('contact.email') }}">{{ __('contact.email') }}</a>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4 mt-8">
                    <a href="{{ route('contact') }}" class="btn-primary">{{ __('nav.contact') }}</a>
                    <a href="https://wa.me/33123456789?text={{ urlencode(__('whatsapp.contact')) }}" target="_blank" class="btn-ghost">
                        <i class="fab fa-whatsapp text-green-400"></i> {{ __('whatsapp.open') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
