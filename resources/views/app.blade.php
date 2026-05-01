<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>

        <title inertia>{{ config('app.name', 'Life Game') }}</title>

        {{-- SEO --}}
        @php
            $locale   = app()->getLocale();
            $baseUrl  = config('app.url');
            $currentPath = request()->getPathInfo();
            $seoMeta  = [
                'en' => [
                    'description' => "Conway Game of Life — interactive simulator. Create, save and share your life configurations.",
                    'og_title'    => "Life Game — Conway Game of Life",
                    'og_desc'     => "Interactive simulator of Conway Game of Life. Create, save and share your configurations.",
                ],
                'fr' => [
                    'description' => "Jeu de la Vie de Conway - simulateur interactif. Créez, sauvegardez et partagez vos configurations.",
                    'og_title'    => "Life Game - Jeu de la Vie de Conway",
                    'og_desc'     => "Simulateur interactif du Jeu de la Vie de Conway. Créez, sauvegardez et partagez vos configurations.",
                ],
            ];
            $meta = $seoMeta[$locale] ?? $seoMeta['en'];
        @endphp
        <meta name="description" content="{{ $meta['description'] }}">
        <meta name="robots" content="index, follow">
        <link rel="canonical" href="{{ $baseUrl }}{{ $currentPath }}">
        <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ $baseUrl }}/sitemap.xml">

        {{-- hreflang: signal both EN and FR versions to Google --}}
        @php
            $langSep = str_contains($currentPath, '?') ? '&' : '?';
        @endphp
        <link rel="alternate" hreflang="en"        href="{{ $baseUrl }}{{ $currentPath }}{{ $langSep }}lang=en">
        <link rel="alternate" hreflang="fr"        href="{{ $baseUrl }}{{ $currentPath }}{{ $langSep }}lang=fr">
        <link rel="alternate" hreflang="x-default" href="{{ $baseUrl }}{{ $currentPath }}">

        {{-- Google Search Console verification --}}
        @if(config('services.google.site_verification'))
        <meta name="google-site-verification" content="{{ config('services.google.site_verification') }}">
        @endif

        {{-- Open Graph --}}
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="{{ config('app.name', 'Life Game') }}">
        <meta property="og:title" content="{{ $meta['og_title'] }}">
        <meta property="og:description" content="{{ $meta['og_desc'] }}">
        <meta property="og:url" content="{{ $baseUrl }}{{ $currentPath }}">
        <meta property="og:image" content="{{ $baseUrl }}/icon-512.png">
        <meta property="og:image:width" content="512">
        <meta property="og:image:height" content="512">
        <meta property="og:locale" content="{{ $locale === 'fr' ? 'fr_FR' : 'en_US' }}">
        <meta property="og:locale:alternate" content="{{ $locale === 'fr' ? 'en_US' : 'fr_FR' }}">

        {{-- Twitter Card --}}
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="{{ $meta['og_title'] }}">
        <meta name="twitter:description" content="{{ $meta['og_desc'] }}">
        <meta name="twitter:image" content="{{ $baseUrl }}/icon-512.png">

        {{-- Favicon --}}
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
        <link rel="icon" type="image/png" sizes="16x16" href="/icon-16.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/icon-32.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/icon-180.png">

        {{-- PWA / Manifest --}}
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="#1a1a1a">

        {{-- JSON-LD Structured Data --}}
        <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "WebApplication",
            "name": "Life Game",
            "description": {{ json_encode($meta['description']) }},
            "url": {{ json_encode($baseUrl) }},
            "inLanguage": ["en", "fr"],
            "applicationCategory": "GameApplication",
            "operatingSystem": "Web",
            "offers": {
                "@@type": "Offer",
                "price": "0",
                "priceCurrency": "EUR"
            },
            "image": {{ json_encode($baseUrl . '/icon-512.png') }}
        }
        </script>

        {{-- Google Analytics GA4 --}}
        @if(config('services.google.analytics_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google.analytics_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config('services.google.analytics_id') }}', {
                'language': '{{ $locale }}'
            });
        </script>
        @endif

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @routes
        @vite(['resources/js/app.ts'])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
