<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PustakaDigital')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        background: '#f7f9fc',
                        'surface-container-lowest': '#ffffff',
                        'surface-container-low': '#f2f4f7',
                        'surface-container': '#eceef1',
                        'surface-container-high': '#e6e8eb',
                        'surface-container-highest': '#e0e3e6',
                        primary: '#000666',
                        'primary-container': '#1a237e',
                        'primary-fixed': '#e0e0ff',
                        secondary: '#2b5bb5',
                        'secondary-container': '#759efd',
                        'secondary-fixed': '#d9e2ff',
                        tertiary: '#006a5d',
                        'tertiary-fixed': '#a0f2e1',
                        error: '#ba1a1a',
                        'error-container': '#ffdad6',
                        'on-surface': '#191c1e',
                        'on-surface-variant': '#454652',
                        outline: '#767683',
                        'outline-variant': '#c6c5d4',
                    },
                    spacing: {
                        xs: '4px',
                        base: '8px',
                        sm: '12px',
                        md: '24px',
                        gutter: '24px',
                        lg: '48px',
                        'margin-mobile': '16px',
                        'margin-desktop': '64px',
                    },
                    borderRadius: {
                        xl: '0.5rem',
                        full: '999px',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        * { letter-spacing: 0; }
        body { font-family: 'Inter', sans-serif; background: #f7f9fc; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 430, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
    </style>
</head>
@php
    $menus = [
        ['label' => 'Dasbor', 'icon' => 'dashboard', 'href' => route('dashboard'), 'active' => request()->routeIs('dashboard')],
        ['label' => 'Katalog Koleksi', 'icon' => 'library_books', 'href' => route('library.index', 'katalog'), 'active' => request()->is('katalog')],
        ['label' => 'Manajemen Anggota', 'icon' => 'group', 'href' => route('library.index', 'anggota'), 'active' => request()->is('anggota')],
        ['label' => 'Sirkulasi', 'icon' => 'sync_alt', 'href' => route('library.index', 'sirkulasi'), 'active' => request()->is('sirkulasi')],
        ['label' => 'Laporan & Statistik', 'icon' => 'monitoring', 'href' => route('library.report'), 'active' => request()->is('laporan')],
        ['label' => 'Pengaturan Staf', 'icon' => 'admin_panel_settings', 'href' => route('library.index', 'staf'), 'active' => request()->is('staf')],
    ];
@endphp
<body class="min-h-screen bg-background text-on-surface">
    <aside class="fixed left-0 top-0 hidden h-screen w-72 flex-col gap-base border-r border-outline-variant bg-surface-container-low p-md md:flex">
        <div class="mb-lg px-xs">
            <h1 class="text-xl font-black text-primary">PustakaDigital</h1>
            <p class="text-sm text-on-surface-variant">Sistem Manajemen</p>
        </div>

        <nav class="flex flex-grow flex-col gap-xs">
            @foreach ($menus as $menu)
                <a href="{{ $menu['href'] }}" class="{{ $menu['active'] ? 'translate-x-1 bg-secondary-container text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-highest hover:text-primary' }} flex items-center gap-sm rounded-xl p-sm transition-all">
                    <span class="material-symbols-outlined">{{ $menu['icon'] }}</span>
                    <span class="text-sm">{{ $menu['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="mt-auto flex items-center gap-sm border-t border-outline-variant pt-md">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary text-sm font-black text-white">AU</div>
            <div>
                <p class="text-sm font-bold">Admin Utama</p>
                <p class="text-xs text-on-surface-variant">Perpustakaan Pusat</p>
            </div>
        </div>
    </aside>

    <main class="min-h-screen pb-24 md:ml-72 md:pb-0">
        <header class="sticky top-0 z-10 flex w-full items-center justify-between border-b border-outline-variant bg-surface-container-lowest px-margin-mobile py-base md:px-margin-desktop">
            <div>
                <h2 class="text-2xl font-bold text-primary md:text-3xl">@yield('page-title')</h2>
                <p class="hidden text-sm text-on-surface-variant md:block">@yield('page-description')</p>
            </div>
            <div class="flex items-center gap-sm">
                <a href="{{ route('library.report') }}" class="hidden rounded-xl border border-outline-variant px-sm py-xs text-sm font-semibold text-primary transition hover:bg-surface-container md:inline-flex">Laporan</a>
                <button type="button" class="rounded-full p-sm text-primary transition-colors hover:bg-surface-container-high" aria-label="Notifikasi">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
            </div>
        </header>

        <div class="space-y-lg p-margin-mobile md:p-margin-desktop">
            @yield('content')
        </div>
    </main>

    <footer class="fixed bottom-0 left-0 z-20 grid w-full grid-cols-5 border-t border-outline-variant bg-surface-container-lowest px-margin-mobile py-base md:hidden">
        @foreach (array_slice($menus, 0, 5) as $menu)
            <a class="{{ $menu['active'] ? 'text-primary' : 'text-on-surface-variant' }} flex flex-col items-center gap-xs" href="{{ $menu['href'] }}">
                <span class="material-symbols-outlined">{{ $menu['icon'] }}</span>
                <span class="max-w-16 truncate text-[11px]">{{ str_replace(['Manajemen ', ' & Statistik'], '', $menu['label']) }}</span>
            </a>
        @endforeach
    </footer>
</body>
</html>
