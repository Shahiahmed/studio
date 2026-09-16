<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\ServiceController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

/*
| Публичные страницы регистрируются по разу на каждый язык из config('studio.locales'):
| русский — на «голых» адресах, казахский — под /kz/. У неосновных языков имена
| маршрутов получают префикс кода (home → kk.home), ссылки строит locale_route().
*/
$pages = function () {
    Route::get('/', HomeController::class)->name('home');

    Route::get('/uslugi', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/uslugi/{slug}', [ServiceController::class, 'show'])
        ->where('slug', '[a-z0-9-]+')
        ->name('services.show');

    Route::get('/work/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');

    Route::post('/leads', [LeadController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('leads.store');
};

$locales = config('studio.locales');
$default = array_key_first($locales);

foreach ($locales as $code => $locale) {
    Route::middleware(SetLocale::class.':'.$code)
        ->prefix($locale['segment'] ?? '')
        ->name($code === $default ? '' : $code.'.')
        ->group($pages);
}

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
