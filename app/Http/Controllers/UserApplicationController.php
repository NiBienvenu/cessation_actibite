<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserApplicationStoreRequest;
use App\Http\Requests\UserApplicationUpdateRequest;
use App\Models\UserApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $userApplications = UserApplication::all();

        return view('userApplication.index', [
            'userApplications' => $userApplications,
        ]);
    }

    public function create(Request $request): View
    {
        return view('userApplication.create');
    }

    public function store(UserApplicationStoreRequest $request): RedirectResponse
    {
        $userApplication = UserApplication::create($request->validated());

        $request->session()->flash('userApplication.id', $userApplication->id);

        return redirect()->route('userApplications.index');
    }

    public function show(Request $request, UserApplication $userApplication): View
    {
        return view('userApplication.show', [
            'userApplication' => $userApplication,
        ]);
    }

    public function edit(Request $request, UserApplication $userApplication): View
    {
        return view('userApplication.edit', [
            'userApplication' => $userApplication,
        ]);
    }

    public function update(UserApplicationUpdateRequest $request, UserApplication $userApplication): RedirectResponse
    {
        $userApplication->update($request->validated());

        $request->session()->flash('userApplication.id', $userApplication->id);

        return redirect()->route('userApplications.index');
    }

    public function destroy(Request $request, UserApplication $userApplication): RedirectResponse
    {
        $userApplication->delete();

        return redirect()->route('userApplications.index');
    }
}
