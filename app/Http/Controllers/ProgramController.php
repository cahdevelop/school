<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class ProgramController extends Controller
{
    public function index(): View
    {
        return view('program.index', [
            'program' => config('program'),
        ]);
    }

    public function show(string $slug): View
    {
        $program = Collection::make(config('program'))->firstWhere('slug', $slug);

        abort_if($program === null, 404, 'Program keahlian tidak ditemukan.');

        return view('program.show', [
            'program' => $program,
            'lainnya' => Collection::make(config('program'))
                ->reject(fn (array $item) => $item['slug'] === $slug)
                ->values(),
        ]);
    }
}
