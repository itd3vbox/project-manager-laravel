<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Base\Task as TaskEntity;

class TaskController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'status' => 'nullable|integer',
            'description_short' => 'nullable|string',
            'description' => 'nullable|array',
            'image_main' => 'nullable|string|max:255',
            'project_id' => 'required|exists:projects,id',
        ]);

        $task = TaskEntity::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Task created successfully.',
            'data' => $task
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = TaskEntity::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $task
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'status' => 'nullable|integer',
            'description_short' => 'nullable|string',
            'description' => 'nullable|array',
            'image_main' => 'nullable|string|max:255',
            'project_id' => 'required|exists:projects,id',
        ]);

        $task = TaskEntity::findOrFail($id);
        $task->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully.',
            'data' => $task
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = TaskEntity::findOrFail($id);
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully.'
        ], 200);
    }
}
