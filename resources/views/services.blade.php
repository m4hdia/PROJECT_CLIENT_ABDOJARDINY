@extends('layouts.main')

@section('title', __('services.title') . ' - ' . __('meta.title'))
@section('description', __('services.subtitle'))

@section('content')
<main class="bg-dark-surface text-white">
    <section class="px-6 py-24 lg:py-32 bg-gradient-to-br from-dark-surface to-dark-surface-elevated text-center">
        <div class="container mx-auto max-w-3xl">
            <p class="section-badge mx-auto">{{ __('services.subtitle') }}</p>
            <h1 class="text-4xl md:text-6xl font-extrabold mt-6">{{ __('services.title') }}</h1>
            <p class="text-gray-300 text-lg md:text-xl mt-6">{{ __('home.signature.text') }}</p>
            <div class="flex flex-wrap gap-4 mt-10 justify-center">
                <a href="{{ route('contact') }}" class="btn-primary">{{ __('nav.cta') }}</a>
                <a href="https://wa.me/33123456789?text={{ urlencode(__('whatsapp.contact')) }}" target="_blank" class="btn-ghost">
                    <i class="fab fa-whatsapp text-green-400"></i> {{ __('whatsapp.open') }}
                </a>
            </div>
        </div>
    </section>

    <section class="px-6 py-20 bg-dark-surface">
        <div class="container mx-auto grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @php
                $services = [
                    ['icon' => 'fa-tree', 'title' => __('services.item2'), 'desc' => __('services.design_desc')],
                    ['icon' => 'fa-tools', 'title' => __('services.item1'), 'desc' => __('services.maintenance_desc')],
                    ['icon' => 'fa-tint', 'title' => __('services.item3'), 'desc' => __('services.irrigation_desc')],
                    ['icon' => 'fa-seedling', 'title' => __('services.item4'), 'desc' => __('services.planting_desc')],
                    ['icon' => 'fa-cut', 'title' => __('services.pruning'), 'desc' => __('services.pruning_desc')],
                    ['icon' => 'fa-bahai', 'title' => __('projects.rooftop'), 'desc' => __('projects.rooftop_desc')],
                ];
            @endphp
            @foreach($services as $service)
                <article class="service-card h-full">
                    <div class="text-green-400 text-4xl mb-6">
                        <i class="fas {{ $service['icon'] }}"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-3">{{ $service['title'] }}</h3>
                    <p class="text-gray-400 mb-6">{{ $service['desc'] }}</p>
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 text-green-300 font-semibold">
                        {{ __('nav.cta') }}
                        <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                </article>
            @endforeach
        </div>
    </section>

    <section class="px-6 py-20 bg-dark-surface-elevated">
        <div class="container mx-auto grid gap-10 lg:grid-cols-2">
            <div class="rounded-[32px] border border-white/10 p-8 bg-dark-surface">
                <p class="section-badge mb-4">{{ __('home.signature.title') }}</p>
                <h2 class="text-3xl font-semibold mb-4">{{ __('services.title') }}</h2>
                <p class="text-gray-300 leading-relaxed">{{ __('services.subtitle') }}</p>
                <div class="mt-8 space-y-6 text-gray-300">
                    <div class="flex gap-4">
                        <span class="text-green-400 font-bold">01</span>
                        <div>
                            <p class="font-semibold">{{ __('home.signature.point1') }}</p>
                            <p class="text-sm text-gray-400">{{ __('gallery.subtitle') }}</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <span class="text-green-400 font-bold">02</span>
                        <div>
                            <p class="font-semibold">{{ __('home.signature.point2') }}</p>
                            <p class="text-sm text-gray-400">{{ __('projects.japanese_desc') }}</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <span class="text-green-400 font-bold">03</span>
                        <div>
                            <p class="font-semibold">{{ __('home.signature.point3') }}</p>
                            <p class="text-sm text-gray-400">{{ __('testimonials.subtitle') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-[32px] border border-white/10 p-8 bg-gradient-to-br from-dark-surface to-dark-surface-elevated">
                <h3 class="text-2xl font-semibold mb-6">{{ __('projects.modern_garden') }}</h3>
                <p class="text-gray-300">{{ __('projects.modern_garden_desc') }}</p>
                <div class="mt-8 grid gap-6 sm:grid-cols-2 text-gray-400">
                    <div>
                        <p class="text-4xl font-bold text-green-300">1200m²</p>
                        <p class="text-sm">{{ __('services.item2') }}</p>
                    </div>
                    <div>
                        <p class="text-4xl font-bold text-green-300">4</p>
                        <p class="text-sm">{{ __('services.item3') }}</p>
                    </div>
                    <div>
                        <p class="text-4xl font-bold text-green-300">18</p>
                        <p class="text-sm">{{ __('services.item4') }}</p>
                    </div>
                    <div>
                        <p class="text-4xl font-bold text-green-300">360°</p>
                        <p class="text-sm">{{ __('projects.rooftop_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="px-6 py-20 bg-dark-surface">
        <div class="container mx-auto grid gap-8 lg:grid-cols-[1.2fr,0.8fr]">
            <div class="border border-white/10 rounded-[32px] p-8 bg-dark-surface-elevated">
                <p class="section-badge mb-4">{{ __('gallery.title') }}</p>
                <h2 class="text-3xl font-semibold mb-6">{{ __('gallery.subtitle') }}</h2>
                <div class="grid gap-6 sm:grid-cols-2 text-gray-300">
                    <div class="space-y-3">
                        <p class="text-sm uppercase tracking-[0.4em] text-gray-500">{{ __('services.item2') }}</p>
                        <p>{{ __('home.features.text1') }}</p>
                    </div>
                    <div class="space-y-3">
                        <p class="text-sm uppercase tracking-[0.4em] text-gray-500">{{ __('services.item3') }}</p>
                        <p>{{ __('home.features.text2') }}</p>
                    </div>
                    <div class="space-y-3">
                        <p class="text-sm uppercase tracking-[0.4em] text-gray-500">{{ __('services.item1') }}</p>
                        <p>{{ __('home.features.text3') }}</p>
                    </div>
                    <div class="space-y-3">
                        <p class="text-sm uppercase tracking-[0.4em] text-gray-500">{{ __('services.item4') }}</p>
                        <p>{{ __('projects.family_desc') }}</p>
                    </div>
                </div>
            </div>
            <div class="border border-white/10 rounded-[32px] p-8 bg-gradient-to-b from-dark-surface-elevated to-dark-surface">
                <h3 class="text-2xl font-semibold mb-4">{{ __('home.projects.case1') }}</h3>
                <p class="text-gray-300">{{ __('home.projects.case1_desc') }}</p>
                <ul class="mt-6 space-y-3 text-gray-400">
                    <li>• {{ __('services.item2') }}</li>
                    <li>• {{ __('services.item3') }}</li>
                    <li>• {{ __('services.item1') }}</li>
                </ul>
                <a href="{{ route('gallery') }}" class="btn-ghost mt-8 inline-flex">{{ __('gallery.view_more') }}</a>
            </div>
        </div>
    </section>

    <section class="px-6 py-20 bg-dark-surface-elevated">
        <div class="container mx-auto text-center">
            <p class="section-badge mx-auto">{{ __('home.cta.title') }}</p>
            <h2 class="text-3xl md:text-5xl font-semibold mt-6">{{ __('home.cta.text') }}</h2>
            <div class="flex flex-wrap gap-4 justify-center mt-10">
                <a href="{{ route('contact') }}" class="btn-primary">{{ __('home.cta.primary') }}</a>
                <a href="https://wa.me/33123456789?text={{ urlencode(__('whatsapp.contact')) }}" target="_blank" class="btn-ghost">
                    <i class="fab fa-whatsapp text-green-400"></i> {{ __('whatsapp.open') }}
                </a>
            </div>
        </div>
    </section>
</main>
@endsection


