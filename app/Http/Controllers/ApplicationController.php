<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationStoreRequest;
use App\Http\Requests\ApplicationUpdateRequest;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $applications = Application::all();

        return view('application.index', [
            'applications' => $applications,
        ]);
    }

    public function create(Request $request): View
    {
        return view('application.create');
    }

    public function store(ApplicationStoreRequest $request): RedirectResponse
    {
        $application = Application::create($request->validated());

        $request->session()->flash('application.id', $application->id);

        return redirect()->route('applications.index');
    }

    public function show(Request $request, Application $application): View
    {
        return view('application.show', [
            'application' => $application,
        ]);
    }

    public function edit(Request $request, Application $application): View
    {
        return view('application.edit', [
            'application' => $application,
        ]);
    }

    public function update(ApplicationUpdateRequest $request, Application $application): RedirectResponse
    {
        $application->update($request->validated());

        $request->session()->flash('application.id', $application->id);

        return redirect()->route('applications.index');
    }

    public function destroy(Request $request, Application $application): RedirectResponse
    {
        $application->delete();

        return redirect()->route('applications.index');
    }
}
