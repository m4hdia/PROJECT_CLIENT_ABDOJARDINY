@extends('layouts.main')

@section('title', __('contact.title') . ' - ' . __('meta.title'))
@section('description', __('contact.subtitle'))

@section('content')
<main class="bg-dark-surface text-white">
    <section class="px-6 py-24 lg:py-32 bg-gradient-to-br from-dark-surface to-dark-surface-elevated text-center">
        <div class="container mx-auto max-w-3xl">
            <p class="section-badge mx-auto">{{ __('contact.subtitle') }}</p>
            <h1 class="text-4xl md:text-6xl font-extrabold mt-6">{{ __('contact.title') }}</h1>
            <p class="text-gray-300 text-lg md:text-xl mt-6">{{ __('home.cta.text') }}</p>
        </div>
    </section>

    <section class="px-6 py-16 bg-dark-surface">
        <div class="container mx-auto grid gap-10 lg:grid-cols-[0.9fr,1.1fr]">
            <div class="space-y-6">
                <div class="p-8 border border-white/10 rounded-[32px] bg-dark-surface-elevated">
                    <p class="section-badge mb-4">{{ __('footer.contact') }}</p>
                    <h2 class="text-2xl font-semibold mb-6">{{ __('contact.cta_title') }}</h2>
                    <div class="space-y-5 text-gray-300">
                        <div class="flex gap-4">
                            <i class="fas fa-map-marker-alt text-green-400 mt-1"></i>
                            <span>{{ __('contact.address') }}</span>
                        </div>
                        <div class="flex gap-4">
                            <i class="fas fa-phone text-green-400 mt-1"></i>
                            <a href="tel:{{ __('contact.phone') }}">{{ __('contact.phone') }}</a>
                        </div>
                        <div class="flex gap-4">
                            <i class="fas fa-envelope text-green-400 mt-1"></i>
                            <a href="mailto:{{ __('contact.email') }}">{{ __('contact.email') }}</a>
                        </div>
                        <div class="flex gap-4">
                            <i class="fas fa-clock text-green-400 mt-1"></i>
                            <span>{{ __('contact.hours') }}</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4 mt-8">
                        <a href="https://wa.me/33123456789?text={{ urlencode(__('whatsapp.contact')) }}" target="_blank" class="btn-primary flex-1 text-center">
                            <i class="fab fa-whatsapp text-green-900"></i> {{ __('contact.cta_whatsapp') }}
                        </a>
                        <a href="{{ route('services') }}" class="btn-ghost flex-1 text-center">
                            {{ __('nav.services') }}
                        </a>
                    </div>
                </div>
                <div class="p-8 border border-white/10 rounded-[32px] bg-gradient-to-br from-dark-surface-elevated to-dark-surface">
                    <p class="section-badge mb-4">{{ __('gallery.title') }}</p>
                    <h3 class="text-2xl font-semibold mb-4">{{ __('home.projects.title') }}</h3>
                    <p class="text-gray-300">{{ __('home.projects.subtitle') }}</p>
                    <ul class="mt-6 space-y-3 text-gray-400">
                        <li>• {{ __('projects.modern_garden_desc') }}</li>
                        <li>• {{ __('projects.traditional_courtyard_desc') }}</li>
                        <li>• {{ __('projects.rooftop_desc') }}</li>
                    </ul>
                </div>
            </div>

            <div class="p-8 border border-white/10 rounded-[32px] bg-dark-surface-elevated">
                <h2 class="text-2xl font-semibold mb-4">{{ __('contact.cta_form') }}</h2>
                <p class="text-gray-300 mb-8">{{ __('contact.cta_subtitle') }}</p>

                @if ($errors->any())
                    <div class="mb-6 text-red-300 bg-red-500/10 border border-red-500/30 rounded-2xl p-4 text-sm">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <div class="mb-6 text-green-300 bg-green-500/10 border border-green-500/30 rounded-2xl p-4 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-semibold mb-2">{{ __('form.name') }}</label>
                        <input type="text" id="name" name="name" required class="w-full rounded-2xl bg-dark-surface border border-white/10 px-4 py-3 focus:border-green-400 focus:outline-none" placeholder="{{ __('form.name') }}">
                    </div>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="email" class="block text-sm font-semibold mb-2">{{ __('form.email') }}</label>
                            <input type="email" id="email" name="email" required class="w-full rounded-2xl bg-dark-surface border border-white/10 px-4 py-3 focus:border-green-400 focus:outline-none" placeholder="{{ __('form.email') }}">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold mb-2">{{ __('form.phone') }}</label>
                            <input type="tel" id="phone" name="phone" required class="w-full rounded-2xl bg-dark-surface border border-white/10 px-4 py-3 focus:border-green-400 focus:outline-none" placeholder="{{ __('form.phone') }}">
                        </div>
                    </div>
                    <div>
                        <label for="service" class="block text-sm font-semibold mb-2">{{ __('form.service') }}</label>
                        <select id="service" name="service" required class="w-full rounded-2xl bg-dark-surface border border-white/10 px-4 py-3 focus:border-green-400 focus:outline-none">
                            <option value="">{{ __('form.select_service') }}</option>
                            <option>{{ __('services.item1') }}</option>
                            <option>{{ __('services.item2') }}</option>
                            <option>{{ __('services.item3') }}</option>
                            <option>{{ __('services.item4') }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-semibold mb-2">{{ __('form.message') }}</label>
                        <textarea id="message" name="message" rows="5" required class="w-full rounded-2xl bg-dark-surface border border-white/10 px-4 py-3 focus:border-green-400 focus:outline-none" placeholder="{{ __('form.message') }}"></textarea>
                    </div>
                    <button type="submit" class="btn-primary w-full justify-center">
                        <i class="fas fa-paper-plane"></i>
                        {{ __('form.submit') }}
                    </button>
                </form>
            </div>
        </div>
    </section>

    <section class="px-6 py-20 bg-dark-surface-elevated">
        <div class="container mx-auto rounded-[32px] border border-white/10 p-8 bg-dark-surface relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(74,222,128,0.15),_transparent_50%)] pointer-events-none"></div>
            <div class="relative z-10 grid gap-10 md:grid-cols-2">
                <div>
                    <p class="section-badge mb-4">{{ __('home.cta.title') }}</p>
                    <h2 class="text-3xl font-semibold mb-4">{{ __('home.cta.text') }}</h2>
                    <p class="text-gray-300">{{ __('gallery.subtitle') }}</p>
                    <div class="flex flex-wrap gap-4 mt-8">
                        <a href="{{ route('contact') }}" class="btn-primary">{{ __('home.cta.primary') }}</a>
                        <a href="{{ route('services') }}" class="btn-ghost">{{ __('home.cta.secondary') }}</a>
                    </div>
                </div>
                <div class="rounded-3xl overflow-hidden border border-white/10 h-72 bg-dark-surface">
                    <iframe title="JARDINX Studio" class="w-full h-full grayscale" src="https://maps.google.com/maps?q=Paris&t=&z=11&ie=UTF8&iwloc=&output=embed" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection


