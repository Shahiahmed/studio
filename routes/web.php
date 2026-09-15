<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/uslugi', [ServiceController::class, 'index'])->name('services.index');
Route::get('/uslugi/{slug}', [ServiceController::class, 'show'])
    ->where('slug', '[a-z0-9-]+')
    ->name('services.show');

Route::get('/work/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::post('/leads', [LeadController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('leads.store');

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
