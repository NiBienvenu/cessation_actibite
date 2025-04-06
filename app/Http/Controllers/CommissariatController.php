<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommissariatStoreRequest;
use App\Http\Requests\CommissariatUpdateRequest;
use App\Models\Commissariat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommissariatController extends Controller
{
    public function index(Request $request): View
    {
        $commissariats = Commissariat::all();

        return view('commissariat.index', [
            'commissariats' => $commissariats,
        ]);
    }

    public function create(Request $request): View
    {
        return view('commissariat.create');
    }

    public function store(CommissariatStoreRequest $request): RedirectResponse
    {
        $commissariat = Commissariat::create($request->validated());

        $request->session()->flash('commissariat.id', $commissariat->id);

        return redirect()->route('commissariats.index');
    }

    public function show(Request $request, Commissariat $commissariat): View
    {
        return view('commissariat.show', [
            'commissariat' => $commissariat,
        ]);
    }

    public function edit(Request $request, Commissariat $commissariat): View
    {
        return view('commissariat.edit', [
            'commissariat' => $commissariat,
        ]);
    }

    public function update(CommissariatUpdateRequest $request, Commissariat $commissariat): RedirectResponse
    {
        $commissariat->update($request->validated());

        $request->session()->flash('commissariat.id', $commissariat->id);

        return redirect()->route('commissariats.index');
    }

    public function destroy(Request $request, Commissariat $commissariat): RedirectResponse
    {
        $commissariat->delete();

        return redirect()->route('commissariats.index');
    }
}
