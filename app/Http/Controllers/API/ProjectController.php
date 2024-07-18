<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Base\Project as ProjectEntity;

class ProjectController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'description_short' => 'nullable|string',
            'status' => 'nullable|integer',
            'folder' => 'nullable|string|max:255',
            'image_main' => 'nullable|string|max:255',
        ]);

        $project = ProjectEntity::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Project created successfully.',
            'data' => $project
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = ProjectEntity::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $project
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'description_short' => 'nullable|string',
            'status' => 'nullable|integer',
            'folder' => 'nullable|string|max:255',
            'image_main' => 'nullable|string|max:255',
        ]);

        $project = ProjectEntity::findOrFail($id);
        $project->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully.',
            'data' => $project
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = ProjectEntity::findOrFail($id);
        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully.'
        ], 200);
    }
}
