<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeStoreRequest;
use App\Http\Requests\EmployeUpdateRequest;
use App\Models\Employe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeController extends Controller
{
    public function index(Request $request): View
    {
        $employes = Employe::all();

        return view('employe.index', [
            'employes' => $employes,
        ]);
    }

    public function create(Request $request): View
    {
        return view('employe.create');
    }

    public function store(EmployeStoreRequest $request): RedirectResponse
    {
        $employe = Employe::create($request->validated());

        $request->session()->flash('employe.id', $employe->id);

        return redirect()->route('employes.index');
    }

    public function show(Request $request, Employe $employe): View
    {
        return view('employe.show', [
            'employe' => $employe,
        ]);
    }

    public function edit(Request $request, Employe $employe): View
    {
        return view('employe.edit', [
            'employe' => $employe,
        ]);
    }

    public function update(EmployeUpdateRequest $request, Employe $employe): RedirectResponse
    {
        $employe->update($request->validated());

        $request->session()->flash('employe.id', $employe->id);

        return redirect()->route('employes.index');
    }

    public function destroy(Request $request, Employe $employe): RedirectResponse
    {
        $employe->delete();

        return redirect()->route('employes.index');
    }
}
