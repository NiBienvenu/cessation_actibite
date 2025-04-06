<?php

namespace App\Http\Controllers;

use App\Http\Requests\MotifStoreRequest;
use App\Http\Requests\MotifUpdateRequest;
use App\Models\Motif;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MotifController extends Controller
{
    public function index(Request $request): View
    {
        $motifs = Motif::all();

        return view('motif.index', [
            'motifs' => $motifs,
        ]);
    }

    public function create(Request $request): View
    {
        return view('motif.create');
    }

    public function store(MotifStoreRequest $request): RedirectResponse
    {
        $motif = Motif::create($request->validated());

        $request->session()->flash('motif.id', $motif->id);

        return redirect()->route('motifs.index');
    }

    public function show(Request $request, Motif $motif): View
    {
        return view('motif.show', [
            'motif' => $motif,
        ]);
    }

    public function edit(Request $request, Motif $motif): View
    {
        return view('motif.edit', [
            'motif' => $motif,
        ]);
    }

    public function update(MotifUpdateRequest $request, Motif $motif): RedirectResponse
    {
        $motif->update($request->validated());

        $request->session()->flash('motif.id', $motif->id);

        return redirect()->route('motifs.index');
    }

    public function destroy(Request $request, Motif $motif): RedirectResponse
    {
        $motif->delete();

        return redirect()->route('motifs.index');
    }
}
