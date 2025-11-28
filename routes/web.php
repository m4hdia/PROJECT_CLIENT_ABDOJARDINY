<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LanguageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Language switcher (must be before middleware)
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

// All routes (SetLocale middleware is applied globally via bootstrap/app.php)
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');
