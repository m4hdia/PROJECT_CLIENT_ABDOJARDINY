<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip locale setting for language switcher route
        if ($request->routeIs('lang.switch')) {
            return $next($request);
        }
        
        $locale = Session::get('locale', 'fr');
        
        // Validate locale
        if (!in_array($locale, ['fr', 'ar'])) {
            $locale = 'fr';
        }
        
        App::setLocale($locale);
        
        return $next($request);
    }
}

