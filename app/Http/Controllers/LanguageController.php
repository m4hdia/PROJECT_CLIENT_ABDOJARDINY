<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    public function switch(Request $request, $locale)
    {
        if (in_array($locale, ['fr', 'ar'])) {
            Session::put('locale', $locale);
            app()->setLocale($locale);
        }
        
        return Redirect::back();
    }
}




