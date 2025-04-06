<?php

namespace App\Http\Controllers;

use App\Http\Requests\FonctionStoreRequest;
use App\Http\Requests\FonctionUpdateRequest;
use App\Models\Fonction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FonctionController extends Controller
{
    public function index(Request $request): View
    {
        $fonctions = Fonction::all();

        return view('fonction.index', [
            'fonctions' => $fonctions,
        ]);
    }

    public function create(Request $request): View
    {
        return view('fonction.create');
    }

    public function store(FonctionStoreRequest $request): RedirectResponse
    {
        $fonction = Fonction::create($request->validated());

        $request->session()->flash('fonction.id', $fonction->id);

        return redirect()->route('fonctions.index');
    }

    public function show(Request $request, Fonction $fonction): View
    {
        return view('fonction.show', [
            'fonction' => $fonction,
        ]);
    }

    public function edit(Request $request, Fonction $fonction): View
    {
        return view('fonction.edit', [
            'fonction' => $fonction,
        ]);
    }

    public function update(FonctionUpdateRequest $request, Fonction $fonction): RedirectResponse
    {
        $fonction->update($request->validated());

        $request->session()->flash('fonction.id', $fonction->id);

        return redirect()->route('fonctions.index');
    }

    public function destroy(Request $request, Fonction $fonction): RedirectResponse
    {
        $fonction->delete();

        return redirect()->route('fonctions.index');
    }
}
