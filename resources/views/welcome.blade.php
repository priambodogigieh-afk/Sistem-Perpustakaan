<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Pantau | PustakaDigital</title>
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
                        surface: '#f7f9fc',
                        'surface-container-lowest': '#ffffff',
                        'surface-container-low': '#f2f4f7',
                        'surface-container': '#eceef1',
                        'surface-container-high': '#e6e8eb',
                        'surface-container-highest': '#e0e3e6',
                        'surface-variant': '#e0e3e6',
                        primary: '#000666',
                        'primary-container': '#1a237e',
                        'primary-fixed': '#e0e0ff',
                        'on-primary': '#ffffff',
                        'on-primary-container': '#dfe2ff',
                        secondary: '#2b5bb5',
                        'secondary-container': '#759efd',
                        'secondary-fixed': '#d9e2ff',
                        'on-secondary-container': '#00337c',
                        tertiary: '#006a5d',
                        'tertiary-container': '#00372f',
                        'tertiary-fixed': '#a0f2e1',
                        error: '#ba1a1a',
                        'error-container': '#ffdad6',
                        'on-surface': '#191c1e',
                        'on-surface-variant': '#454652',
                        outline: '#767683',
                        'outline-variant': '#c6c5d4',
                    },
                    borderRadius: {
                        DEFAULT: '0.125rem',
                        lg: '0.25rem',
                        xl: '0.5rem',
                        full: '999px',
                    },
                    spacing: {
                        xs: '4px',
                        base: '8px',
                        sm: '12px',
                        md: '24px',
                        gutter: '24px',
                        lg: '48px',
                        xl: '80px',
                        'margin-mobile': '16px',
                        'margin-desktop': '64px',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    fontSize: {
                        caption: ['12px', { lineHeight: '16px', fontWeight: '400' }],
                        'label-md': ['14px', { lineHeight: '20px', fontWeight: '500' }],
                        'body-md': ['16px', { lineHeight: '24px', fontWeight: '400' }],
                        'title-md': ['20px', { lineHeight: '28px', fontWeight: '600' }],
                        'headline-mobile': ['24px', { lineHeight: '32px', fontWeight: '700' }],
                        'headline-lg': ['32px', { lineHeight: '40px', fontWeight: '700' }],
                    },
                },
            },
        };
    </script>
    <style>
        * {
            letter-spacing: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f7f9fc;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 430, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .book-cover {
            position: relative;
            isolation: isolate;
            overflow: hidden;
        }

        .book-cover::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(135deg, rgba(255, 255, 255, .42), transparent 38%),
                radial-gradient(circle at 80% 18%, rgba(255, 255, 255, .42), transparent 24%),
                linear-gradient(90deg, rgba(0, 0, 0, .18), transparent 14%);
            z-index: -1;
        }

        .book-cover::after {
            content: '';
            position: absolute;
            inset: 10px;
            border: 1px solid rgba(255, 255, 255, .48);
            border-radius: 6px;
            pointer-events: none;
        }
    </style>
</head>
@php
    $menuItems = [
        ['label' => 'Dasbor', 'icon' => 'dashboard', 'href' => route('dashboard'), 'active' => true],
        ['label' => 'Katalog Koleksi', 'icon' => 'library_books', 'href' => route('library.index', 'katalog'), 'active' => false],
        ['label' => 'Manajemen Anggota', 'icon' => 'group', 'href' => route('library.index', 'anggota'), 'active' => false],
        ['label' => 'Sirkulasi', 'icon' => 'sync_alt', 'href' => route('library.index', 'sirkulasi'), 'active' => false],
        ['label' => 'Laporan & Statistik', 'icon' => 'monitoring', 'href' => route('library.report'), 'active' => false],
        ['label' => 'Pengaturan Staf', 'icon' => 'admin_panel_settings', 'href' => route('library.index', 'staf'), 'active' => false],
    ];

    $stats = [
        ['label' => 'Total Koleksi', 'value' => '24,582', 'detail' => 'Buku, jurnal & media', 'icon' => 'auto_stories', 'tone' => 'primary', 'badge' => '12%', 'badgeIcon' => 'arrow_upward'],
        ['label' => 'Anggota Aktif', 'value' => '1,840', 'detail' => 'Peningkatan bulan ini', 'icon' => 'person_check', 'tone' => 'secondary', 'badge' => '5%', 'badgeIcon' => 'arrow_upward'],
        ['label' => 'Peminjaman Hari Ini', 'value' => '142', 'detail' => 'Rata-rata 120 per hari', 'icon' => 'import_contacts', 'tone' => 'tertiary', 'badge' => 'Harian', 'badgeIcon' => null],
        ['label' => 'Buku Terlambat', 'value' => '28', 'detail' => 'Menunggu pengembalian', 'icon' => 'history_toggle_off', 'tone' => 'error', 'badge' => 'Perhatian', 'badgeIcon' => null],
    ];

    $bars = [
        ['month' => 'Jan', 'height' => 'h-32', 'active' => false],
        ['month' => 'Feb', 'height' => 'h-40', 'active' => false],
        ['month' => 'Mar', 'height' => 'h-24', 'active' => false],
        ['month' => 'Apr', 'height' => 'h-56', 'active' => true],
        ['month' => 'Mei', 'height' => 'h-48', 'active' => false],
        ['month' => 'Jun', 'height' => 'h-36', 'active' => false],
    ];

    $activities = [
        ['name' => 'Andi Saputra', 'action' => 'meminjam', 'book' => 'Laskar Pelangi', 'time' => 'Baru saja', 'tone' => 'bg-primary'],
        ['name' => 'Siti Aminah', 'action' => 'mengembalikan', 'book' => 'Pulang', 'time' => '15 menit yang lalu', 'tone' => 'bg-secondary'],
        ['name' => 'Budi Rejeki', 'action' => 'terlambat mengembalikan', 'book' => 'Bumi Manusia', 'time' => '1 jam yang lalu', 'tone' => 'bg-error', 'danger' => true],
        ['name' => 'Rina Lestari', 'action' => 'mendaftar sebagai anggota baru', 'book' => null, 'time' => '2 jam yang lalu', 'tone' => 'bg-tertiary'],
    ];

    $books = [
        ['title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'views' => '842', 'status' => 'TERSEDIA', 'available' => true, 'rank' => 'TOP 1', 'cover' => 'from-sky-300 via-indigo-500 to-blue-950'],
        ['title' => 'Bumi Manusia', 'author' => 'Pramoedya Ananta Toer', 'views' => '651', 'status' => 'DIPINJAM', 'available' => false, 'rank' => null, 'cover' => 'from-stone-300 via-amber-700 to-zinc-950'],
        ['title' => 'Pulang', 'author' => 'Leila S. Chudori', 'views' => '432', 'status' => 'TERSEDIA', 'available' => true, 'rank' => null, 'cover' => 'from-cyan-200 via-blue-700 to-slate-950'],
        ['title' => 'Sistem Informasi', 'author' => 'Jogiyanto Hartono', 'views' => '389', 'status' => 'TERSEDIA', 'available' => true, 'rank' => null, 'cover' => 'from-slate-100 via-sky-500 to-indigo-900'],
        ['title' => 'Filosofi Teras', 'author' => 'Henry Manampiring', 'views' => '312', 'status' => 'DIPINJAM', 'available' => false, 'rank' => null, 'cover' => 'from-emerald-100 via-teal-500 to-slate-800'],
    ];
@endphp
<body class="min-h-screen bg-background text-on-surface">
    <aside class="fixed left-0 top-0 hidden h-screen w-64 flex-col gap-base border-r border-outline-variant bg-surface-container-low p-md md:flex">
        <div class="mb-lg px-xs">
            <h1 class="text-title-md font-black text-primary">PustakaDigital</h1>
            <p class="text-label-md text-on-surface-variant">Sistem Manajemen</p>
        </div>

        <nav class="flex flex-grow flex-col gap-xs">
            @foreach ($menuItems as $item)
                <a href="{{ $item['href'] }}" class="{{ $item['active'] ? 'translate-x-1 bg-secondary-container text-on-secondary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-highest hover:text-primary' }} flex items-center gap-sm rounded-xl p-sm transition-all">
                    <span class="material-symbols-outlined">{{ $item['icon'] }}</span>
                    <span class="text-label-md">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="mt-auto flex items-center gap-sm border-t border-outline-variant pt-md">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary text-sm font-black text-on-primary">AU</div>
            <div>
                <p class="text-label-md font-bold">Admin Utama</p>
                <p class="text-caption text-on-surface-variant">Perpustakaan Pusat</p>
            </div>
        </div>
    </aside>

    <main class="min-h-screen pb-24 md:ml-64 md:pb-0">
        <header class="sticky top-0 z-10 flex w-full items-center justify-between border-b border-outline-variant bg-surface-container-lowest px-margin-mobile py-base md:px-margin-desktop">
            <h2 class="text-headline-mobile font-bold text-primary md:text-headline-lg">Dasbor Pantau</h2>

            <div class="flex items-center gap-sm">
                <label class="hidden items-center gap-xs rounded-full border border-outline-variant bg-surface-container px-sm py-xs transition focus-within:ring-2 focus-within:ring-primary/20 md:flex">
                    <span class="material-symbols-outlined text-on-surface-variant">search</span>
                    <input class="w-64 border-none bg-transparent text-body-md placeholder:text-on-surface-variant focus:ring-0" placeholder="Cari laporan atau data..." type="text">
                </label>
                <button type="button" class="rounded-full p-sm text-primary transition-colors hover:bg-surface-container-high" aria-label="Notifikasi">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <button type="button" class="rounded-full p-sm text-primary transition-colors hover:bg-surface-container-high" aria-label="Bantuan">
                    <span class="material-symbols-outlined">help_outline</span>
                </button>
            </div>
        </header>

        <div class="space-y-lg p-margin-mobile md:p-margin-desktop">
            <section class="grid grid-cols-1 gap-gutter sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($stats as $stat)
                    @php
                        $isError = $stat['tone'] === 'error';
                        $iconClasses = match ($stat['tone']) {
                            'secondary' => 'bg-secondary-fixed text-secondary',
                            'tertiary' => 'bg-tertiary-fixed text-tertiary-container',
                            'error' => 'bg-error-container text-error',
                            default => 'bg-primary-fixed text-primary',
                        };
                    @endphp
                    <article class="group flex flex-col gap-xs rounded-xl border border-outline-variant bg-surface-container-lowest p-md transition-all hover:-translate-y-1 hover:border-{{ $isError ? 'error' : 'primary' }} hover:shadow-lg">
                        <div class="flex items-start justify-between">
                            <span class="material-symbols-outlined rounded-full p-sm {{ $iconClasses }}">{{ $stat['icon'] }}</span>
                            <span class="{{ $isError ? 'text-error' : ($stat['tone'] === 'tertiary' ? 'text-tertiary' : 'text-green-600') }} flex items-center text-label-md font-semibold">
                                @if ($stat['badgeIcon'])
                                    <span class="material-symbols-outlined text-sm">{{ $stat['badgeIcon'] }}</span>
                                @endif
                                {{ $stat['badge'] }}
                            </span>
                        </div>
                        <p class="mt-sm text-label-md text-on-surface-variant">{{ $stat['label'] }}</p>
                        <h3 class="{{ $isError ? 'text-error' : 'text-primary' }} text-headline-lg">{{ $stat['value'] }}</h3>
                        <p class="text-caption text-outline">{{ $stat['detail'] }}</p>
                    </article>
                @endforeach
            </section>

            <section class="grid grid-cols-1 gap-gutter lg:grid-cols-3">
                <article class="rounded-xl border border-outline-variant bg-surface-container-lowest p-md lg:col-span-2">
                    <div class="mb-lg flex flex-wrap items-center justify-between gap-sm">
                        <h4 class="text-title-md font-bold text-primary">Tren Peminjaman Bulanan</h4>
                        <select class="rounded-lg border-none bg-surface-container text-label-md focus:ring-primary">
                            <option>Tahun 2026</option>
                            <option>Tahun 2025</option>
                            <option>Tahun 2024</option>
                        </select>
                    </div>
                    <div class="flex h-64 items-end justify-between gap-base border-b border-outline-variant px-base pb-base">
                        @foreach ($bars as $bar)
                            <div class="flex h-full w-full min-w-0 flex-col items-center justify-end gap-xs">
                                <div class="{{ $bar['height'] }} w-full rounded-t-lg transition-all {{ $bar['active'] ? 'bg-primary-container shadow-lg' : 'bg-secondary-container opacity-40 hover:opacity-100' }}"></div>
                                <span class="text-caption {{ $bar['active'] ? 'font-bold text-primary' : 'text-on-surface-variant' }}">{{ $bar['month'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </article>

                <article class="flex flex-col rounded-xl border border-outline-variant bg-surface-container-lowest p-md">
                    <h4 class="mb-md text-title-md font-bold text-primary">Aktivitas Terbaru</h4>
                    <div class="no-scrollbar flex-grow space-y-md overflow-y-auto">
                        @foreach ($activities as $activity)
                            <div class="flex items-start gap-sm">
                                <div class="mt-1 h-10 w-2 shrink-0 rounded-full {{ $activity['tone'] }}"></div>
                                <div>
                                    <p class="text-body-md">
                                        <span class="font-bold">{{ $activity['name'] }}</span>
                                        {{ $activity['action'] }}
                                        @if ($activity['book'])
                                            <span class="{{ $activity['danger'] ?? false ? 'text-error' : 'text-primary' }} italic">{{ $activity['book'] }}</span>
                                        @endif
                                    </p>
                                    <p class="text-caption text-outline">{{ $activity['time'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('library.index', 'sirkulasi') }}" class="mt-lg block w-full rounded-xl border border-outline-variant py-sm text-center text-label-md font-semibold text-primary transition-colors hover:bg-surface-container">
                        Lihat Semua Aktivitas
                    </a>
                </article>
            </section>

            <section class="space-y-md">
                <div class="flex flex-wrap items-center justify-between gap-sm">
                    <h4 class="text-title-md font-bold text-primary">Buku Populer Bulan Ini</h4>
                    <a class="flex items-center gap-xs text-label-md font-semibold text-secondary" href="{{ route('library.index', 'katalog') }}">
                        Lihat Koleksi Lengkap
                        <span class="material-symbols-outlined">chevron_right</span>
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-md md:grid-cols-4 lg:grid-cols-5">
                    @foreach ($books as $index => $book)
                        <article class="{{ $index === 4 ? 'hidden lg:block' : '' }} group rounded-xl border border-outline-variant bg-surface-container-lowest p-sm transition-all hover:-translate-y-1 hover:shadow-xl">
                            <div class="book-cover mb-sm flex aspect-[3/4] flex-col justify-between rounded-lg bg-gradient-to-br {{ $book['cover'] }} p-sm text-white">
                                @if ($book['rank'])
                                    <span class="ml-auto rounded bg-on-secondary-container px-xs py-0.5 text-[10px] font-bold">{{ $book['rank'] }}</span>
                                @else
                                    <span></span>
                                @endif
                                <div>
                                    <p class="text-[10px] font-semibold uppercase opacity-80">PustakaDigital</p>
                                    <p class="mt-xs text-sm font-black leading-tight">{{ $book['title'] }}</p>
                                </div>
                            </div>
                            <h5 class="truncate text-body-md font-bold">{{ $book['title'] }}</h5>
                            <p class="truncate text-caption text-on-surface-variant">{{ $book['author'] }}</p>
                            <div class="mt-sm flex items-center justify-between gap-xs">
                                <span class="{{ $book['available'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full px-sm py-0.5 text-[10px] font-bold">{{ $book['status'] }}</span>
                                <span class="flex items-center gap-xs text-caption text-on-surface-variant">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                    {{ $book['views'] }}
                                </span>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        </div>
    </main>

    <footer class="fixed bottom-0 left-0 z-20 flex w-full items-center justify-around border-t border-outline-variant bg-surface-container-lowest px-margin-mobile py-base md:hidden">
        @foreach (array_slice($menuItems, 0, 4) as $item)
            <a class="{{ $item['active'] ? 'text-primary' : 'text-on-surface-variant' }} flex flex-col items-center gap-xs" href="{{ $item['href'] }}">
                <span class="material-symbols-outlined">{{ $item['icon'] }}</span>
                <span class="text-caption">{{ str_replace(['Manajemen ', ' & Statistik', 'Pengaturan '], '', $item['label']) }}</span>
            </a>
        @endforeach
    </footer>

    <script>
        document.querySelectorAll('article.group').forEach((card) => {
            card.addEventListener('pointerenter', () => card.classList.add('shadow-md'));
            card.addEventListener('pointerleave', () => card.classList.remove('shadow-md'));
        });
    </script>
</body>
</html>
