<?php

namespace App\Http\Controllers;

use App\Http\Requests\CessationActiviteStoreRequest;
use App\Http\Requests\CessationActiviteUpdateRequest;
use App\Models\CessationActivite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CessationActiviteController extends Controller
{
    public function index(Request $request): View
    {
        $cessationActivites = CessationActivite::all();

        return view('cessationActivite.index', [
            'cessationActivites' => $cessationActivites,
        ]);
    }

    public function create(Request $request): View
    {
        return view('cessationActivite.create');
    }

    public function store(CessationActiviteStoreRequest $request): RedirectResponse
    {
        $cessationActivite = CessationActivite::create($request->validated());

        $request->session()->flash('cessationActivite.id', $cessationActivite->id);

        return redirect()->route('cessationActivites.index');
    }

    public function show(Request $request, CessationActivite $cessationActivite): View
    {
        return view('cessationActivite.show', [
            'cessationActivite' => $cessationActivite,
        ]);
    }

    public function edit(Request $request, CessationActivite $cessationActivite): View
    {
        return view('cessationActivite.edit', [
            'cessationActivite' => $cessationActivite,
        ]);
    }

    public function update(CessationActiviteUpdateRequest $request, CessationActivite $cessationActivite): RedirectResponse
    {
        $cessationActivite->update($request->validated());

        $request->session()->flash('cessationActivite.id', $cessationActivite->id);

        return redirect()->route('cessationActivites.index');
    }

    public function destroy(Request $request, CessationActivite $cessationActivite): RedirectResponse
    {
        $cessationActivite->delete();

        return redirect()->route('cessationActivites.index');
    }
}
