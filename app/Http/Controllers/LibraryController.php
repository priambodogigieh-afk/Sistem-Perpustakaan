<?php

namespace App\Http\Controllers;

use App\Support\LibraryDataStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryController extends Controller
{
    public function __construct(private readonly LibraryDataStore $store)
    {
    }

    public function index(string $section): View
    {
        return view('library.index', [
            'sectionKey' => $section,
            'section' => $this->store->section($section),
            'items' => $this->store->all($section),
            'sections' => $this->store->sections(),
        ]);
    }

    public function store(Request $request, string $section): RedirectResponse
    {
        $this->store->create($section, $this->payload($request, $section));

        return redirect()->route('library.index', ['section' => $section, 'created' => 1]);
    }

    public function update(Request $request, string $section, string $id): RedirectResponse
    {
        $this->store->update($section, $id, $this->payload($request, $section));

        return redirect()->route('library.index', ['section' => $section, 'updated' => 1]);
    }

    public function destroy(string $section, string $id): RedirectResponse
    {
        $this->store->delete($section, $id);

        return redirect()->route('library.index', ['section' => $section, 'deleted' => 1]);
    }

    public function report(): View
    {
        return view('library.report', [
            'sections' => $this->store->sections(),
            'report' => $this->store->report(),
            'collections' => $this->store->all('katalog'),
            'circulations' => $this->store->all('sirkulasi'),
        ]);
    }

    private function payload(Request $request, string $section): array
    {
        $payload = [];

        foreach ($this->store->section($section)['fields'] as $field) {
            $value = trim((string) $request->input($field['name'], ''));
            $payload[$field['name']] = $value;
        }

        return $payload;
    }
}
