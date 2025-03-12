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
        if (!$user) {
            return Inertia::render('Login');
        }
        $save = Save::updateOrCreate(
            ['id' => $request->id],
            [
                'user_id' => $user->id,
                'grid' => $validated['grid'],
                'grid_size' => $validated['grid_size'],
                'update_speed' => $validated['update_speed'],
                'neighbor_thresholds' => $validated['neighbor_thresholds'],
                'selected_color' => $validated['selected_color']
            ]
        );
        $save->save();
        return Inertia::render('Home', [
            'id' => $save->id
        ]);
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
