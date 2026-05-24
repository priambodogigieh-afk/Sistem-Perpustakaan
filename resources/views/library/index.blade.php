@extends('library.layout')

@section('title', $section['title'] . ' | PustakaDigital')
@section('page-title', $section['title'])
@section('page-description', $section['description'])

@php
    $notice = match (true) {
        request()->has('created') => 'Data berhasil ditambahkan.',
        request()->has('updated') => 'Data berhasil diperbarui.',
        request()->has('deleted') => 'Data berhasil dihapus.',
        default => null,
    };

    $statusClass = function (string $status): string {
        return match ($status) {
            'Tersedia', 'Aktif', 'Dikembalikan' => 'bg-green-100 text-green-800',
            'Dipinjam', 'Cuti' => 'bg-blue-100 text-blue-800',
            'Terlambat', 'Ditangguhkan', 'Nonaktif' => 'bg-red-100 text-red-800',
            default => 'bg-slate-100 text-slate-700',
        };
    };
@endphp

@section('content')
    @if ($notice)
        <div class="rounded-xl border border-green-200 bg-green-50 px-md py-sm text-sm font-semibold text-green-800">
            {{ $notice }}
        </div>
    @endif

    <section class="rounded-xl border border-outline-variant bg-surface-container-lowest p-md">
        <div class="mb-md flex items-center gap-sm">
            <span class="material-symbols-outlined rounded-full bg-primary-fixed p-sm text-primary">{{ $section['icon'] }}</span>
            <div>
                <h3 class="text-xl font-bold text-primary">Tambah {{ ucfirst($section['singular']) }}</h3>
                <p class="text-sm text-on-surface-variant">Isi data baru lalu simpan ke daftar {{ strtolower($section['title']) }}.</p>
            </div>
        </div>

        <form action="{{ route('library.store', $sectionKey) }}" method="POST" class="grid grid-cols-1 gap-sm md:grid-cols-2 xl:grid-cols-5">
            @foreach ($section['fields'] as $field)
                <label class="flex flex-col gap-xs text-sm font-semibold text-on-surface-variant">
                    {{ $field['label'] }}
                    @if ($field['type'] === 'select')
                        <select name="{{ $field['name'] }}" class="rounded-lg border-outline-variant bg-white text-on-surface focus:border-primary focus:ring-primary" {{ $field['required'] ? 'required' : '' }}>
                            @foreach ($field['options'] as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </select>
                    @else
                        <input name="{{ $field['name'] }}" type="{{ $field['type'] }}" class="rounded-lg border-outline-variant bg-white text-on-surface focus:border-primary focus:ring-primary" {{ $field['required'] ? 'required' : '' }}>
                    @endif
                </label>
            @endforeach
            <div class="flex items-end">
                <button type="submit" class="inline-flex w-full items-center justify-center gap-xs rounded-xl bg-primary px-md py-sm text-sm font-bold text-white transition hover:bg-primary-container">
                    <span class="material-symbols-outlined text-base">add</span>
                    Simpan
                </button>
            </div>
        </form>
    </section>

    <section class="space-y-md">
        <div class="flex flex-wrap items-center justify-between gap-sm">
            <div>
                <h3 class="text-xl font-bold text-primary">Daftar {{ $section['title'] }}</h3>
                <p class="text-sm text-on-surface-variant">{{ count($items) }} data tersimpan.</p>
            </div>
            <a href="{{ route('library.report') }}" class="inline-flex items-center gap-xs text-sm font-semibold text-secondary">
                Lihat laporan
                <span class="material-symbols-outlined text-base">chevron_right</span>
            </a>
        </div>

        @forelse ($items as $item)
            <article class="rounded-xl border border-outline-variant bg-surface-container-lowest p-md transition hover:border-primary hover:shadow-lg">
                <div class="mb-md flex flex-wrap items-center justify-between gap-sm">
                    <div>
                        <h4 class="text-lg font-bold text-primary">
                            {{ $item['title'] ?? $item['name'] ?? $item['member'] ?? 'Data' }}
                        </h4>
                        <p class="text-sm text-on-surface-variant">
                            {{ $item['author'] ?? $item['role'] ?? $item['book'] ?? $item['member_code'] ?? 'Kelola detail data' }}
                        </p>
                    </div>
                    @if (isset($item['status']))
                        <span class="{{ $statusClass($item['status']) }} rounded-full px-sm py-xs text-xs font-bold">{{ $item['status'] }}</span>
                    @endif
                </div>

                <form id="update-{{ $item['id'] }}" action="{{ route('library.update', [$sectionKey, $item['id']]) }}" method="POST" class="grid grid-cols-1 gap-sm md:grid-cols-2 xl:grid-cols-5">
                    @method('PUT')
                    @foreach ($section['fields'] as $field)
                        <label class="flex flex-col gap-xs text-sm font-semibold text-on-surface-variant">
                            {{ $field['label'] }}
                            @if ($field['type'] === 'select')
                                <select name="{{ $field['name'] }}" class="rounded-lg border-outline-variant bg-white text-on-surface focus:border-primary focus:ring-primary" {{ $field['required'] ? 'required' : '' }}>
                                    @foreach ($field['options'] as $option)
                                        <option value="{{ $option }}" @selected(($item[$field['name']] ?? '') === $option)>{{ $option }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input name="{{ $field['name'] }}" type="{{ $field['type'] }}" value="{{ $item[$field['name']] ?? '' }}" class="rounded-lg border-outline-variant bg-white text-on-surface focus:border-primary focus:ring-primary" {{ $field['required'] ? 'required' : '' }}>
                            @endif
                        </label>
                    @endforeach
                </form>

                <div class="mt-md flex flex-wrap justify-end gap-sm">
                    <form action="{{ route('library.destroy', [$sectionKey, $item['id']]) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-xs rounded-xl border border-red-200 px-md py-sm text-sm font-bold text-error transition hover:bg-error-container">
                            <span class="material-symbols-outlined text-base">delete</span>
                            Hapus
                        </button>
                    </form>
                    <button type="submit" form="update-{{ $item['id'] }}" class="inline-flex items-center gap-xs rounded-xl bg-secondary px-md py-sm text-sm font-bold text-white transition hover:bg-primary">
                        <span class="material-symbols-outlined text-base">save</span>
                        Perbarui
                    </button>
                </div>
            </article>
        @empty
            <div class="rounded-xl border border-dashed border-outline-variant bg-surface-container-lowest p-lg text-center">
                <span class="material-symbols-outlined text-4xl text-outline">inbox</span>
                <h3 class="mt-sm text-lg font-bold text-primary">Belum ada data</h3>
                <p class="text-sm text-on-surface-variant">Tambahkan {{ strtolower($section['singular']) }} pertama melalui formulir di atas.</p>
            </div>
        @endforelse
    </section>
@endsection
