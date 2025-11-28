@extends('layouts.main')

@section('title', __('gallery.title') . ' - ' . __('meta.title'))
@section('description', __('gallery.subtitle'))

@push('styles')
<style>
    .gallery-card {
        position: relative;
        border-radius: 28px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(17, 23, 20, 0.8);
        min-height: 320px;
    }
    .gallery-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }
    .gallery-card:hover img {
        transform: scale(1.08);
    }
    .gallery-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(5, 7, 6, 0.1), rgba(5, 7, 6, 0.85));
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 1.75rem;
        color: white;
        opacity: 0;
        transition: opacity 0.35s ease;
    }
    .gallery-card:hover .gallery-overlay {
        opacity: 1;
    }
    .filter-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        transition: all 0.3s ease;
    }
    .filter-btn.active {
        background: var(--accent-green);
        color: var(--dark-bg);
        border-color: var(--accent-green);
    }
</style>
@endpush

@section('content')
<main class="bg-dark-surface text-white">
    <section class="px-6 py-24 lg:py-32 bg-gradient-to-br from-dark-surface to-dark-surface-elevated text-center">
        <div class="container mx-auto max-w-3xl">
            <p class="section-badge mx-auto">{{ __('gallery.subtitle') }}</p>
            <h1 class="text-4xl md:text-6xl font-extrabold mt-6">{{ __('gallery.title') }}</h1>
            <p class="text-gray-300 text-lg md:text-xl mt-6">{{ __('home.signature.text') }}</p>
        </div>
    </section>

    <section class="px-6 py-16 bg-dark-surface">
        <div class="container mx-auto">
            <div class="flex flex-wrap gap-3 justify-center">
                @php
                    $filters = [
                        ['key' => 'all', 'label' => __('gallery.view_more')],
                        ['key' => 'gardens', 'label' => __('nav.home')],
                        ['key' => 'terraces', 'label' => __('projects.rooftop')],
                    ];
                @endphp
                @foreach($filters as $filter)
                    <button class="filter-btn {{ $loop->first ? 'active' : '' }}" data-filter="{{ $filter['key'] }}">
                        {{ $filter['label'] }}
                    </button>
                @endforeach
            </div>

            @php
                $items = [
                    ['img' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200&q=80', 'title' => __('projects.modern_garden'), 'cat' => 'gardens'],
                    ['img' => 'https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?w=1200&q=80', 'title' => __('projects.rooftop'), 'cat' => 'terraces'],
                    ['img' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=1200&q=80', 'title' => __('projects.japanese'), 'cat' => 'gardens'],
                    ['img' => 'https://images.unsplash.com/photo-1516253593875-bd7ba052fbc5?w=1200&q=80', 'title' => __('projects.traditional_courtyard'), 'cat' => 'gardens'],
                    ['img' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?w=1200&q=80', 'title' => __('projects.family'), 'cat' => 'gardens'],
                    ['img' => 'https://images.unsplash.com/photo-1530836369250-ef72a3f5cda8?w=1200&q=80', 'title' => __('projects.family'), 'cat' => 'terraces'],
                ];
            @endphp

            <div class="grid gap-6 mt-10 md:grid-cols-3">
                @foreach($items as $item)
                    <article class="gallery-card" data-category="{{ $item['cat'] }}">
                        <img src="{{ $item['img'] }}" alt="{{ $item['title'] }}" loading="lazy">
                        <div class="gallery-overlay">
                            <h3 class="text-xl font-semibold">{{ $item['title'] }}</h3>
                            <p class="text-sm text-gray-300">{{ __('gallery.view_project') }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="px-6 py-20 bg-dark-surface-elevated">
        <div class="container mx-auto grid gap-8 lg:grid-cols-2">
            <div class="rounded-[32px] border border-white/10 p-8 bg-dark-surface">
                <p class="section-badge mb-4">{{ __('home.projects.title') }}</p>
                <h2 class="text-3xl font-semibold mb-4">{{ __('home.projects.subtitle') }}</h2>
                <p class="text-gray-300">{{ __('projects.traditional_courtyard_desc') }}</p>
                <ul class="mt-6 space-y-3 text-gray-400">
                    <li>• {{ __('services.item2') }}</li>
                    <li>• {{ __('services.item3') }}</li>
                    <li>• {{ __('services.item1') }}</li>
                </ul>
            </div>
            <div class="rounded-[32px] border border-white/10 p-8 bg-gradient-to-br from-dark-surface to-dark-surface-elevated">
                <h3 class="text-2xl font-semibold mb-4">{{ __('home.projects.case2') }}</h3>
                <p class="text-gray-300">{{ __('home.projects.case2_desc') }}</p>
                <div class="mt-8 grid gap-6 sm:grid-cols-2 text-gray-400">
                    <div>
                        <p class="text-4xl font-bold text-green-300">4</p>
                        <p class="text-sm">{{ __('services.item3') }}</p>
                    </div>
                    <div>
                        <p class="text-4xl font-bold text-green-300">18</p>
                        <p class="text-sm">{{ __('services.item4') }}</p>
                    </div>
                    <div>
                        <p class="text-4xl font-bold text-green-300">72</p>
                        <p class="text-sm">{{ __('services.item1') }}</p>
                    </div>
                    <div>
                        <p class="text-4xl font-bold text-green-300">∞</p>
                        <p class="text-sm">{{ __('services.subtitle') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="px-6 py-20 bg-dark-surface text-center">
        <div class="container mx-auto">
            <p class="section-badge mx-auto">{{ __('home.cta.title') }}</p>
            <h2 class="text-3xl md:text-5xl font-semibold mt-6">{{ __('home.cta.text') }}</h2>
            <div class="flex flex-wrap gap-4 justify-center mt-10">
                <a href="{{ route('contact') }}" class="btn-primary">{{ __('home.cta.primary') }}</a>
                <a href="{{ route('services') }}" class="btn-ghost">{{ __('home.cta.secondary') }}</a>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buttons = document.querySelectorAll('.filter-btn');
        const cards = document.querySelectorAll('.gallery-card');

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                buttons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const filter = btn.dataset.filter;
                cards.forEach(card => {
                    if (filter === 'all' || card.dataset.category === filter) {
                        card.style.display = 'block';
                        setTimeout(() => card.style.opacity = '1', 10);
                    } else {
                        card.style.opacity = '0';
                        setTimeout(() => card.style.display = 'none', 200);
                    }
                });
            });
        });
    });
</script>
@endpush


