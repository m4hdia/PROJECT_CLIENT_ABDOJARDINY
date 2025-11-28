@extends('layouts.main')

@section('title', __('meta.title'))
@section('description', __('meta.description'))
@section('keywords', __('meta.keywords'))

@push('styles')
<style>
    .hero-luxe {
        position: relative;
        min-height: calc(100vh - 80px);
        padding: clamp(6rem, 12vw, 8rem) clamp(1.5rem, 4vw, 4rem);
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 3rem;
        background: radial-gradient(circle at top, rgba(74, 222, 128, 0.12), transparent 50%),
                    linear-gradient(135deg, rgba(10, 14, 11, 0.95) 10%, rgba(26, 33, 28, 0.92) 50%, rgba(15, 45, 21, 0.95) 90%);
        overflow: hidden;
    }

    .hero-media {
        position: relative;
        border-radius: 32px;
        overflow: hidden;
        background: url('/images/hero-gardener-working.jpg') center/cover no-repeat;
        min-height: 420px;
        box-shadow: 0 40px 120px rgba(0, 0, 0, 0.55);
    }

    .hero-media::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(12, 16, 14, 0.2), rgba(12, 16, 14, 0.85));
    }

    .floating-blob {
        position: absolute;
        top: 20%;
        left: 15%;
        width: 140px;
        height: 140px;
        background: radial-gradient(circle, rgba(74, 222, 128, 0.5), transparent 65%);
        filter: blur(20px);
        animation: float 12s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translate3d(0, 0, 0); }
        50% { transform: translate3d(20px, -20px, 0); }
    }

    .hero-card {
        position: absolute;
        bottom: 24px;
        left: 24px;
        right: 24px;
        padding: 1.75rem;
        border-radius: 24px;
        background: rgba(10, 14, 11, 0.75);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: white;
        z-index: 2;
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 2.5rem;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.65rem;
        background: linear-gradient(135deg, var(--accent-green), #22c55e);
        color: var(--dark-bg);
        padding: 1.1rem 2.5rem;
        border-radius: 999px;
        font-weight: 600;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 20px 30px rgba(74, 222, 128, 0.25);
    }

    .btn-primary:hover {
        transform: translateY(-2px) scale(1.01);
        box-shadow: 0 25px 40px rgba(74, 222, 128, 0.35);
    }

    .btn-ghost {
        display: inline-flex;
        align-items: center;
        gap: 0.65rem;
        padding: 1.1rem 2.5rem;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: inherit;
        transition: border-color 0.3s ease, color 0.3s ease;
    }

    .btn-ghost:hover {
        border-color: var(--accent-green);
        color: var(--accent-green);
    }

    .section-shell {
        padding: clamp(4rem, 9vw, 6.5rem) clamp(1.5rem, 4vw, 4rem);
    }

    .section-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 1rem;
        border-radius: 999px;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        background: rgba(74, 222, 128, 0.12);
        color: var(--accent-green);
    }

    .grid-3 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.75rem;
        margin-top: 2.5rem;
    }

    .feature-card,
    .service-card,
    .metric-card,
    .testimonial-card {
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(17, 23, 20, 0.8);
        padding: 2rem;
        height: 100%;
        transition: transform 0.35s ease, border-color 0.35s ease;
    }

    .feature-card:hover,
    .service-card:hover,
    .metric-card:hover,
    .testimonial-card:hover {
        transform: translateY(-6px);
        border-color: rgba(74, 222, 128, 0.4);
    }

    .signature-panel {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2.5rem;
        margin-top: 3rem;
        align-items: center;
    }

    .signature-panel img {
        border-radius: 28px;
        object-fit: cover;
        width: 100%;
        height: 420px;
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.45);
    }

    .project-slider {
        position: relative;
        border-radius: 32px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.08);
        min-height: 460px;
        background: rgba(10, 14, 11, 0.6);
    }

    .project-slider img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .project-slider img:first-child {
        clip-path: polygon(0 0, 50% 0, 50% 100%, 0 100%);
    }

    .slider-handle {
        position: absolute;
        top: 0;
        left: 50%;
        width: 4px;
        height: 100%;
        background: white;
        cursor: ew-resize;
        z-index: 2;
    }

    .slider-handle::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: white;
        transform: translate(-50%, -50%);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.35);
    }

    .slider-handle::after {
        content: '\2194';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -45%);
        color: var(--dark-bg);
        font-weight: 700;
    }

    .slider-label {
        position: absolute;
        top: 1.5rem;
        padding: 0.35rem 1rem;
        border-radius: 999px;
        background: rgba(0, 0, 0, 0.65);
        font-weight: 600;
        letter-spacing: 0.08em;
        font-size: 0.75rem;
    }

    .slider-label.after {
        right: 1.5rem;
    }

    .slider-label.before {
        left: 1.5rem;
    }

    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 2.5rem;
    }

    .metric-pill {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding: 1.25rem 1.75rem;
        border-radius: 999px;
        background: rgba(74, 222, 128, 0.12);
        color: var(--accent-green);
        backdrop-filter: blur(10px);
    }

    .metric-pill span {
        font-size: 2rem;
        font-weight: 700;
    }

    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .reveal.visible {
        opacity: 1;
        transform: none;
    }

    .cta-panel {
        border-radius: 36px;
        padding: clamp(2rem, 5vw, 4rem);
        background: linear-gradient(135deg, rgba(17, 23, 20, 0.9), rgba(32, 46, 38, 0.95));
        border: 1px solid rgba(255, 255, 255, 0.08);
        position: relative;
        overflow: hidden;
    }

    .cta-panel::after {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, rgba(74, 222, 128, 0.18), transparent 40%);
        pointer-events: none;
    }

    @media (max-width: 1024px) {
        .hero-luxe {
            grid-template-columns: 1fr;
        }
        .hero-media {
            min-height: 360px;
        }
    }
</style>
@endpush

@section('content')
<main class="overflow-hidden text-white">
    <section class="hero-luxe">
        <div class="hero-content reveal visible">
            <p class="section-badge">
                <span class="w-2 h-2 rounded-full bg-green-400 inline-block"></span>
                {{ __('home.badge') }}
            </p>
            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mt-6">
                {{ __('hero.title') }}
            </h1>
            <p class="text-lg md:text-xl text-gray-300 mt-6 max-w-2xl">
                {{ __('hero.description') }}
            </p>

            <div class="hero-actions">
                <a href="{{ route('contact') }}" class="btn-primary">
                    <i class="fas fa-phone-volume"></i>
                    {{ __('home.cta.primary') }}
                </a>
                <a href="https://wa.me/33123456789?text={{ urlencode(__('whatsapp.contact')) }}" target="_blank" class="btn-ghost">
                    <i class="fab fa-whatsapp text-green-400"></i>
                    {{ __('hero.cta.whatsapp') }}
                </a>
            </div>

            <div class="hero-actions" style="margin-top: 1.5rem;">
                <div class="metric-pill">
                    <span>15+</span>
                    <small>{{ __('about.stats.years') }}</small>
                </div>
                <div class="metric-pill">
                    <span>500+</span>
                    <small>{{ __('about.stats.projects') }}</small>
                </div>
                <div class="metric-pill">
                    <span>98%</span>
                    <small>{{ __('about.stats.clients') }}</small>
                </div>
            </div>
        </div>

        <div class="hero-media reveal visible">
            <div class="floating-blob"></div>
            <div class="hero-card">
                <p class="text-sm uppercase tracking-[0.4em] text-gray-400 mb-3">{{ __('home.signature.title') }}</p>
                <p class="text-lg text-gray-200 mb-4">{{ __('home.signature.text') }}</p>
                <div class="space-y-2 text-sm text-gray-300">
                    <div>• {{ __('home.signature.point1') }}</div>
                    <div>• {{ __('home.signature.point2') }}</div>
                    <div>• {{ __('home.signature.point3') }}</div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-shell bg-dark-surface">
        <header class="max-w-3xl reveal">
            <p class="section-badge">{{ __('services.subtitle') }}</p>
            <h2 class="text-3xl md:text-5xl font-bold mt-4">{{ __('home.signature.title') }}</h2>
            <p class="text-gray-400 mt-4">{{ __('home.signature.text') }}</p>
        </header>

        <div class="grid-3">
            <article class="feature-card reveal" style="transition-delay: 0.1s;">
                <h3 class="text-xl font-semibold mb-3 text-white">{{ __('home.features.title1') }}</h3>
                <p class="text-gray-400">{{ __('home.features.text1') }}</p>
            </article>
            <article class="feature-card reveal" style="transition-delay: 0.2s;">
                <h3 class="text-xl font-semibold mb-3 text-white">{{ __('home.features.title2') }}</h3>
                <p class="text-gray-400">{{ __('home.features.text2') }}</p>
            </article>
            <article class="feature-card reveal" style="transition-delay: 0.3s;">
                <h3 class="text-xl font-semibold mb-3 text-white">{{ __('home.features.title3') }}</h3>
                <p class="text-gray-400">{{ __('home.features.text3') }}</p>
            </article>
        </div>
    </section>

    <section class="section-shell bg-dark-surface-elevated">
        <div class="signature-panel">
            <div class="reveal">
                <p class="section-badge">{{ __('nav.services') }}</p>
                <h2 class="text-3xl md:text-4xl font-semibold mt-4">{{ __('services.title') }}</h2>
                <p class="text-gray-400 mt-4">{{ __('services.subtitle') }}</p>
                <div class="mt-6 space-y-3 text-gray-300">
                    <div>• {{ __('services.item2') }} — {{ __('services.design_desc') }}</div>
                    <div>• {{ __('services.item1') }} — {{ __('services.maintenance_desc') }}</div>
                    <div>• {{ __('services.item3') }} — {{ __('services.irrigation_desc') }}</div>
                    <div>• {{ __('services.item4') }} — {{ __('services.planting_desc') }}</div>
                </div>
                <a href="{{ route('services') }}" class="btn-ghost mt-8 inline-flex">
                    {{ __('nav.services') }} <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <img src="/images/projects/japanese-garden.jpg" alt="JARDINX Project" class="reveal" style="transition-delay: 0.15s;">
        </div>
    </section>

    <section class="section-shell bg-dark-surface">
        <header class="text-center reveal">
            <p class="section-badge mx-auto">{{ __('home.projects.title') }}</p>
            <h2 class="text-3xl md:text-5xl font-semibold mt-4">{{ __('home.projects.subtitle') }}</h2>
        </header>

        <div class="grid-3" style="grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));">
            <article class="project-slider reveal" data-slider>
                <img src="/images/projects/modern-garden-before.jpg" alt="Avant">
                <img src="/images/projects/modern-garden-after.jpg" alt="Après">
                <div class="slider-handle"></div>
                <span class="slider-label before">{{ __('gallery.before') }}</span>
                <span class="slider-label after">{{ __('gallery.after') }}</span>
            </article>
            <div class="service-card reveal">
                <p class="text-sm uppercase tracking-[0.5em] text-gray-400 mb-3">{{ __('home.projects.case1') }}</p>
                <h3 class="text-2xl font-bold mb-4">{{ __('projects.modern_garden') }}</h3>
                <p class="text-gray-400 mb-6">{{ __('home.projects.case1_desc') }}</p>
                <ul class="space-y-3 text-gray-300">
                    <li>• {{ __('services.item2') }}</li>
                    <li>• {{ __('services.item3') }}</li>
                    <li>• {{ __('services.item1') }}</li>
                </ul>
            </div>
            <div class="service-card reveal" style="transition-delay: 0.15s;">
                <p class="text-sm uppercase tracking-[0.5em] text-gray-400 mb-3">{{ __('home.projects.case2') }}</p>
                <h3 class="text-2xl font-bold mb-4">{{ __('projects.traditional_courtyard') }}</h3>
                <p class="text-gray-400 mb-6">{{ __('home.projects.case2_desc') }}</p>
                <ul class="space-y-3 text-gray-300">
                    <li>• {{ __('projects.japanese') }}</li>
                    <li>• {{ __('services.item4') }}</li>
                    <li>• {{ __('services.item3') }}</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="section-shell bg-dark-surface-elevated">
        <header class="text-center reveal">
            <p class="section-badge mx-auto">{{ __('testimonials.title') }}</p>
            <h2 class="text-3xl md:text-5xl font-semibold mt-4">{{ __('testimonials.subtitle') }}</h2>
        </header>
        <div class="grid-3">
            <article class="testimonial-card reveal">
                <p class="text-gray-200 italic mb-4">“{{ __('testimonials.testimonial1') }}”</p>
                <p class="text-sm text-gray-400">{{ __('testimonials.client1_name') }} — {{ __('testimonials.client1_location') }}</p>
            </article>
            <article class="testimonial-card reveal" style="transition-delay: 0.12s;">
                <p class="text-gray-200 italic mb-4">“{{ __('testimonials.testimonial2') }}”</p>
                <p class="text-sm text-gray-400">{{ __('testimonials.client2_name') }} — {{ __('testimonials.client2_location') }}</p>
            </article>
            <article class="testimonial-card reveal" style="transition-delay: 0.22s;">
                <p class="text-gray-200 italic mb-4">“{{ __('testimonials.testimonial3') }}”</p>
                <p class="text-sm text-gray-400">{{ __('testimonials.client3_name') }} — {{ __('testimonials.client3_location') }}</p>
            </article>
        </div>
    </section>

    <section class="section-shell bg-dark-surface">
        <div class="cta-panel reveal">
            <div class="relative z-10 flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="section-badge">{{ __('home.projects.title') }}</p>
                    <h2 class="text-3xl md:text-4xl font-bold mt-4">{{ __('home.cta.title') }}</h2>
                    <p class="text-gray-300 mt-4 max-w-2xl">{{ __('home.cta.text') }}</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('contact') }}" class="btn-primary">{{ __('home.cta.primary') }}</a>
                    <a href="{{ route('services') }}" class="btn-ghost">{{ __('home.cta.secondary') }}</a>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const revealElements = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.2 });

        revealElements.forEach(el => observer.observe(el));

        const sliders = document.querySelectorAll('[data-slider]');
        sliders.forEach(slider => {
            const beforeImage = slider.querySelector('img:first-child');
            const handle = slider.querySelector('.slider-handle');
            let active = false;

            const setPosition = (clientX) => {
                const rect = slider.getBoundingClientRect();
                let x = clientX - rect.left;
                x = Math.max(0, Math.min(x, rect.width));
                const percent = (x / rect.width) * 100;
                beforeImage.style.clipPath = `polygon(0 0, ${percent}% 0, ${percent}% 100%, 0 100%)`;
                handle.style.left = `${percent}%`;
            };

            const start = (event) => {
                active = true;
                slider.classList.add('active');
                const clientX = event.touches ? event.touches[0].clientX : event.clientX;
                setPosition(clientX);
            };

            const move = (event) => {
                if (!active) return;
                const clientX = event.touches ? event.touches[0].clientX : event.clientX;
                setPosition(clientX);
            };

            const end = () => {
                active = false;
                slider.classList.remove('active');
            };

            handle.addEventListener('mousedown', start);
            handle.addEventListener('touchstart', start);
            window.addEventListener('mousemove', move);
            window.addEventListener('touchmove', move);
            window.addEventListener('mouseup', end);
            window.addEventListener('touchend', end);
        });
    });
</script>
@endpush


