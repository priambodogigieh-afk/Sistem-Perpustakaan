<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LibraryDataStore
{
    private string $path;

    public function __construct()
    {
        $this->path = storage_path('app/library-data.json');
    }

    public function sections(): array
    {
        return [
            'katalog' => [
                'title' => 'Katalog Koleksi',
                'singular' => 'koleksi',
                'icon' => 'library_books',
                'description' => 'Kelola buku, jurnal, media digital, dan status ketersediaan koleksi.',
                'fields' => [
                    ['name' => 'title', 'label' => 'Judul', 'type' => 'text', 'required' => true],
                    ['name' => 'author', 'label' => 'Penulis', 'type' => 'text', 'required' => true],
                    ['name' => 'category', 'label' => 'Kategori', 'type' => 'text', 'required' => true],
                    ['name' => 'year', 'label' => 'Tahun', 'type' => 'number', 'required' => true],
                    ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['Tersedia', 'Dipinjam', 'Perawatan'], 'required' => true],
                ],
                'columns' => ['title', 'author', 'category', 'year', 'status'],
            ],
            'anggota' => [
                'title' => 'Manajemen Anggota',
                'singular' => 'anggota',
                'icon' => 'group',
                'description' => 'Kelola data anggota aktif, kontak, dan status keanggotaan.',
                'fields' => [
                    ['name' => 'member_code', 'label' => 'Kode Anggota', 'type' => 'text', 'required' => true],
                    ['name' => 'name', 'label' => 'Nama', 'type' => 'text', 'required' => true],
                    ['name' => 'class', 'label' => 'Kelas/Unit', 'type' => 'text', 'required' => true],
                    ['name' => 'phone', 'label' => 'Telepon', 'type' => 'text', 'required' => true],
                    ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['Aktif', 'Nonaktif', 'Ditangguhkan'], 'required' => true],
                ],
                'columns' => ['member_code', 'name', 'class', 'phone', 'status'],
            ],
            'sirkulasi' => [
                'title' => 'Sirkulasi',
                'singular' => 'transaksi',
                'icon' => 'sync_alt',
                'description' => 'Catat peminjaman, tenggat pengembalian, dan status transaksi.',
                'fields' => [
                    ['name' => 'member', 'label' => 'Anggota', 'type' => 'text', 'required' => true],
                    ['name' => 'book', 'label' => 'Koleksi', 'type' => 'text', 'required' => true],
                    ['name' => 'borrow_date', 'label' => 'Tanggal Pinjam', 'type' => 'date', 'required' => true],
                    ['name' => 'due_date', 'label' => 'Jatuh Tempo', 'type' => 'date', 'required' => true],
                    ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['Dipinjam', 'Dikembalikan', 'Terlambat'], 'required' => true],
                ],
                'columns' => ['member', 'book', 'borrow_date', 'due_date', 'status'],
            ],
            'staf' => [
                'title' => 'Pengaturan Staf',
                'singular' => 'staf',
                'icon' => 'admin_panel_settings',
                'description' => 'Kelola akun staf, peran kerja, dan status akses sistem.',
                'fields' => [
                    ['name' => 'name', 'label' => 'Nama Staf', 'type' => 'text', 'required' => true],
                    ['name' => 'role', 'label' => 'Peran', 'type' => 'select', 'options' => ['Admin', 'Pustakawan', 'Operator Sirkulasi'], 'required' => true],
                    ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true],
                    ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['Aktif', 'Cuti', 'Nonaktif'], 'required' => true],
                ],
                'columns' => ['name', 'role', 'email', 'status'],
            ],
        ];
    }

    public function section(string $section): array
    {
        return $this->sections()[$section];
    }

    public function all(string $section): array
    {
        $data = $this->read();

        return $data[$section] ?? [];
    }

    public function create(string $section, array $attributes): array
    {
        $data = $this->read();
        $record = array_merge(['id' => (string) Str::uuid()], $attributes);
        $data[$section][] = $record;
        $this->write($data);

        return $record;
    }

    public function update(string $section, string $id, array $attributes): ?array
    {
        $data = $this->read();
        $records = $data[$section] ?? [];

        foreach ($records as $index => $record) {
            if (($record['id'] ?? null) !== $id) {
                continue;
            }

            $data[$section][$index] = array_merge($record, $attributes);
            $this->write($data);

            return $data[$section][$index];
        }

        return null;
    }

    public function delete(string $section, string $id): bool
    {
        $data = $this->read();
        $before = count($data[$section] ?? []);
        $data[$section] = array_values(array_filter($data[$section] ?? [], fn (array $record) => ($record['id'] ?? null) !== $id));
        $this->write($data);

        return count($data[$section]) !== $before;
    }

    public function report(): array
    {
        $data = $this->read();

        return [
            'total_collections' => count($data['katalog'] ?? []),
            'available_collections' => count(array_filter($data['katalog'] ?? [], fn (array $item) => ($item['status'] ?? '') === 'Tersedia')),
            'active_members' => count(array_filter($data['anggota'] ?? [], fn (array $item) => ($item['status'] ?? '') === 'Aktif')),
            'borrowed_items' => count(array_filter($data['sirkulasi'] ?? [], fn (array $item) => ($item['status'] ?? '') === 'Dipinjam')),
            'late_items' => count(array_filter($data['sirkulasi'] ?? [], fn (array $item) => ($item['status'] ?? '') === 'Terlambat')),
            'active_staff' => count(array_filter($data['staf'] ?? [], fn (array $item) => ($item['status'] ?? '') === 'Aktif')),
        ];
    }

    private function read(): array
    {
        if (! File::exists($this->path)) {
            $this->write($this->seed());
        }

        $content = File::get($this->path);
        $data = json_decode($content, true);

        return is_array($data) ? $data : $this->seed();
    }

    private function write(array $data): void
    {
        File::ensureDirectoryExists(dirname($this->path));
        File::put($this->path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    private function seed(): array
    {
        return [
            'katalog' => [
                ['id' => 'book-1', 'title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'category' => 'Novel', 'year' => '2005', 'status' => 'Tersedia'],
                ['id' => 'book-2', 'title' => 'Bumi Manusia', 'author' => 'Pramoedya Ananta Toer', 'category' => 'Sastra', 'year' => '1980', 'status' => 'Dipinjam'],
                ['id' => 'book-3', 'title' => 'Sistem Informasi', 'author' => 'Jogiyanto Hartono', 'category' => 'Teknologi', 'year' => '2017', 'status' => 'Tersedia'],
            ],
            'anggota' => [
                ['id' => 'member-1', 'member_code' => 'AGT-001', 'name' => 'Andi Saputra', 'class' => 'XII IPA', 'phone' => '081234567890', 'status' => 'Aktif'],
                ['id' => 'member-2', 'member_code' => 'AGT-002', 'name' => 'Siti Aminah', 'class' => 'Guru', 'phone' => '081298765432', 'status' => 'Aktif'],
            ],
            'sirkulasi' => [
                ['id' => 'loan-1', 'member' => 'Andi Saputra', 'book' => 'Laskar Pelangi', 'borrow_date' => '2026-05-20', 'due_date' => '2026-05-27', 'status' => 'Dipinjam'],
                ['id' => 'loan-2', 'member' => 'Budi Rejeki', 'book' => 'Bumi Manusia', 'borrow_date' => '2026-05-10', 'due_date' => '2026-05-17', 'status' => 'Terlambat'],
            ],
            'staf' => [
                ['id' => 'staff-1', 'name' => 'Admin Utama', 'role' => 'Admin', 'email' => 'admin@pustakadigital.test', 'status' => 'Aktif'],
                ['id' => 'staff-2', 'name' => 'Rina Lestari', 'role' => 'Pustakawan', 'email' => 'rina@pustakadigital.test', 'status' => 'Aktif'],
            ],
        ];
    }
}
