<?php

use App\Http\Controllers\SaveController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

Route::middleware('auth')->group(function () {
    Route::post('/', [SaveController::class, 'store'])->name('save.store');
});

Route::get('dashboard', function () {
    return SaveController::userSaves();
})->middleware(['auth', 'verified'])->name('dashboard');

// Sitemap XML (avec annotations hreflang pour EN + FR)
Route::get('/sitemap.xml', function () {
    $baseUrl = config('app.url');
    $urls = [
        ['loc' => $baseUrl . '/'],
    ];

    $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
    $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

    foreach ($urls as $url) {
        $loc = $url['loc'];
        $xml .= '  <url>' . "\n";
        $xml .= '    <loc>' . $loc . '</loc>' . "\n";
        $xml .= '    <xhtml:link rel="alternate" hreflang="en"        href="' . $loc . '"/>' . "\n";
        $xml .= '    <xhtml:link rel="alternate" hreflang="fr"        href="' . $loc . '"/>' . "\n";
        $xml .= '    <xhtml:link rel="alternate" hreflang="x-default" href="' . $loc . '"/>' . "\n";
        $xml .= '    <changefreq>weekly</changefreq>' . "\n";
        $xml .= '    <priority>1.0</priority>' . "\n";
        $xml .= '  </url>' . "\n";
    }

    $xml .= '</urlset>';
    return Response::make($xml, 200, ['Content-Type' => 'application/xml']);
})->name('sitemap');

// Robots.txt dynamique (inclut l'URL du sitemap)
Route::get('/robots.txt', function () {
    $baseUrl = config('app.url');
    $content = "User-agent: *\n";
    $content .= "Allow: /\n";
    $content .= "Disallow: /dashboard\n";
    $content .= "Disallow: /settings\n";
    $content .= "Disallow: /login\n";
    $content .= "Disallow: /register\n\n";
    $content .= "Sitemap: {$baseUrl}/sitemap.xml\n";
    return Response::make($content, 200, ['Content-Type' => 'text/plain']);
})->name('robots');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::get('/{id?}', function ($id = null) {
    return SaveController::show($id);
})->name('home');
