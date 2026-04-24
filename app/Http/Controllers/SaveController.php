<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSaveRequest;
use App\Models\Save;
use Inertia\Inertia;
use Inertia\Response;

class SaveController extends Controller
{
    public static function userSaves(): Response
    {
        return Inertia::render('Dashboard', [
            'saves' => Save::where('user_id', auth()->user()->id)
                ->select(['id', 'grid_size', 'cycle_count', 'created_at'])
                ->orderByDesc('created_at')
                ->get(),
        ]);
    }

    public function store(CreateSaveRequest $request)
    {
        $validated = $request->validated();
        $user = auth()->user();

        $attributes = [
            'user_id' => $user->id,
            'grid' => $validated['grid'],
            'grid_size' => $validated['grid_size'],
            'update_speed' => $validated['update_speed'],
            'neighbor_thresholds' => $validated['neighbor_thresholds'],
            'selected_color' => $validated['selected_color'],
            'cycle_count' => $validated['cycle_count'],
        ];

        if (! empty($validated['id'])) {
            $save = Save::where('id', $validated['id'])->where('user_id', $user->id)->first();
            if ($save) {
                $save->fill($attributes)->save();
            } else {
                $save = Save::create($attributes);
            }
        } else {
            $save = Save::create($attributes);
        }

        return Inertia::render('Home', [
            'id' => $save->id,
        ]);
    }

    public static function show($id = null)
    {
        if (! $id) {
            return Inertia::render('Home');
        }

        $save = Save::find($id);

        if (! $save) {
            abort(404);
        }

        return Inertia::render('Home', [
            'id' => $save->id,
            'settings' => $save->settings,
            'grid' => $save->grid,
            'cycleCount' => $save->cycle_count,
        ]);
    }

    public function update(CreateSaveRequest $request, Save $save)
    {
        //
    }

    public function destroy(Save $save)
    {
        //
    }
}
