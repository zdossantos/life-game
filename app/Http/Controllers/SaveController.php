<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSaveRequest;
use App\Models\Save;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SaveController extends Controller
{
    public function create()
    {
        //
    }

    public function store(CreateSaveRequest $request)
    {
        $validated = $request->validated();
        $user = auth()->user();
        if(!$user) {
            return Inertia::render('Login');
        }
        $save = new Save();
        $save->user_id = $user->id;
        $save->grid = $validated['grid'];
        $save->grid_size = $validated['grid_size'];
        $save->update_speed = $validated['update_speed'];
        $save->neighbor_thresholds = $validated['neighbor_thresholds'];
        $save->selected_color = $validated['selected_color'];
        $save->save();
        return Inertia::render('Home');
    }

    public function show(Save $save)
    {
        //
    }

    public function update(Request $request, Save $save)
    {
        //
    }

    public function destroy(Save $save)
    {
        //
    }
}
