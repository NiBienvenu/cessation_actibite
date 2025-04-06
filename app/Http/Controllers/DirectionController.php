<?php

namespace App\Http\Controllers;

use App\Http\Requests\DirectionStoreRequest;
use App\Http\Requests\DirectionUpdateRequest;
use App\Models\Direction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DirectionController extends Controller
{
    public function index(Request $request): View
    {
        $directions = Direction::all();

        return view('direction.index', [
            'directions' => $directions,
        ]);
    }

    public function create(Request $request): View
    {
        return view('direction.create');
    }

    public function store(DirectionStoreRequest $request): RedirectResponse
    {
        $direction = Direction::create($request->validated());

        $request->session()->flash('direction.id', $direction->id);

        return redirect()->route('directions.index');
    }

    public function show(Request $request, Direction $direction): View
    {
        return view('direction.show', [
            'direction' => $direction,
        ]);
    }

    public function edit(Request $request, Direction $direction): View
    {
        return view('direction.edit', [
            'direction' => $direction,
        ]);
    }

    public function update(DirectionUpdateRequest $request, Direction $direction): RedirectResponse
    {
        $direction->update($request->validated());

        $request->session()->flash('direction.id', $direction->id);

        return redirect()->route('directions.index');
    }

    public function destroy(Request $request, Direction $direction): RedirectResponse
    {
        $direction->delete();

        return redirect()->route('directions.index');
    }
}
