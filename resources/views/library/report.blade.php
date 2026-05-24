@extends('library.layout')

@section('title', 'Laporan & Statistik | PustakaDigital')
@section('page-title', 'Laporan & Statistik')
@section('page-description', 'Ringkasan data koleksi, anggota, sirkulasi, dan staf perpustakaan.')

@php
    $cards = [
        ['label' => 'Total Koleksi', 'value' => $report['total_collections'], 'icon' => 'auto_stories', 'tone' => 'bg-primary-fixed text-primary'],
        ['label' => 'Koleksi Tersedia', 'value' => $report['available_collections'], 'icon' => 'inventory_2', 'tone' => 'bg-green-100 text-green-800'],
        ['label' => 'Anggota Aktif', 'value' => $report['active_members'], 'icon' => 'person_check', 'tone' => 'bg-secondary-fixed text-secondary'],
        ['label' => 'Sedang Dipinjam', 'value' => $report['borrowed_items'], 'icon' => 'sync_alt', 'tone' => 'bg-blue-100 text-blue-800'],
        ['label' => 'Terlambat', 'value' => $report['late_items'], 'icon' => 'history_toggle_off', 'tone' => 'bg-error-container text-error'],
        ['label' => 'Staf Aktif', 'value' => $report['active_staff'], 'icon' => 'admin_panel_settings', 'tone' => 'bg-tertiary-fixed text-tertiary'],
    ];
@endphp

@section('content')
    <section class="grid grid-cols-1 gap-gutter sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($cards as $card)
            <article class="rounded-xl border border-outline-variant bg-surface-container-lowest p-md transition hover:-translate-y-1 hover:border-primary hover:shadow-lg">
                <div class="flex items-center justify-between">
                    <span class="{{ $card['tone'] }} material-symbols-outlined rounded-full p-sm">{{ $card['icon'] }}</span>
                    <span class="text-sm font-semibold text-on-surface-variant">Saat ini</span>
                </div>
                <p class="mt-md text-sm font-semibold text-on-surface-variant">{{ $card['label'] }}</p>
                <h3 class="mt-xs text-3xl font-black text-primary">{{ $card['value'] }}</h3>
            </article>
        @endforeach
    </section>

    <section class="grid grid-cols-1 gap-gutter lg:grid-cols-2">
        <article class="rounded-xl border border-outline-variant bg-surface-container-lowest p-md">
            <div class="mb-md flex items-center justify-between">
                <h3 class="text-xl font-bold text-primary">Status Koleksi</h3>
                <a href="{{ route('library.index', 'katalog') }}" class="text-sm font-semibold text-secondary">Kelola</a>
            </div>
            <div class="space-y-sm">
                @foreach ($collections as $collection)
                    <div class="flex items-center justify-between rounded-lg bg-surface-container-low p-sm">
                        <div>
                            <p class="font-bold text-primary">{{ $collection['title'] }}</p>
                            <p class="text-sm text-on-surface-variant">{{ $collection['author'] }} · {{ $collection['category'] }}</p>
                        </div>
                        <span class="rounded-full bg-white px-sm py-xs text-xs font-bold text-on-surface-variant">{{ $collection['status'] }}</span>
                    </div>
                @endforeach
            </div>
        </article>

        <article class="rounded-xl border border-outline-variant bg-surface-container-lowest p-md">
            <div class="mb-md flex items-center justify-between">
                <h3 class="text-xl font-bold text-primary">Sirkulasi Terbaru</h3>
                <a href="{{ route('library.index', 'sirkulasi') }}" class="text-sm font-semibold text-secondary">Kelola</a>
            </div>
            <div class="space-y-sm">
                @foreach ($circulations as $circulation)
                    <div class="flex items-center justify-between rounded-lg bg-surface-container-low p-sm">
                        <div>
                            <p class="font-bold text-primary">{{ $circulation['member'] }}</p>
                            <p class="text-sm text-on-surface-variant">{{ $circulation['book'] }} · Tempo {{ $circulation['due_date'] }}</p>
                        </div>
                        <span class="rounded-full bg-white px-sm py-xs text-xs font-bold text-on-surface-variant">{{ $circulation['status'] }}</span>
                    </div>
                @endforeach
            </div>
        </article>
    </section>
@endsection
