<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Base\Automate as AutomateEntity;

class AutomateController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'description_short' => 'nullable|string|max:255',
            'description' => 'nullable|json',
            'command' => 'nullable|string',
            'duration' => 'nullable|integer',
            'status' => 'nullable|integer',
            'folder' => 'nullable|string|max:255',
            'project_id' => 'required|integer|exists:projects,id',
        ]);

        $automate = AutomateEntity::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Automate created successfully.',
            'data' => $automate
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $automate = AutomateEntity::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $automate
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'description_short' => 'nullable|string|max:255',
            'description' => 'nullable|json',
            'command' => 'nullable|string',
            'duration' => 'nullable|integer',
            'status' => 'nullable|integer',
            'folder' => 'nullable|string|max:255',
            'project_id' => 'required|integer|exists:projects,id',
        ]);

        $automate = AutomateEntity::findOrFail($id);
        $automate->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Automate updated successfully.',
            'data' => $automate
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $automate = AutomateEntity::findOrFail($id);
        $automate->delete();

        return response()->json([
            'success' => true,
            'message' => 'Automate deleted successfully.'
        ], 200);
    }
}
