<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Base\Automate as AutomateEntity;
use App\Services\API\Search\AutomateSearchService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AutomateController extends Controller
{
    protected $automateSearchService;

    public function __construct(AutomateSearchService $automateSearchService)
    {
        $this->automateSearchService = $automateSearchService;
    }

    /**
     * Display a listing of the resource.
     */
    public function search(Request $request) : JsonResponse
    {
        $validated = $request->validate([
            'is_asc' => 'nullable|boolean',
            'max' => 'nullable|integer|min:1|max:100',
            'project_id' => 'nullable|integer|exists:projects,id',
        ]);

        $options = array_merge([
            'is_asc' => false,
            'max' => 20,
        ], $validated);

        $automates = $this->automateSearchService->searchAll($options);

        return response()->json([
            'message' => 'Automates retrieved successfully',
            'data' => $automates,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $automate = AutomateEntity::find($id);

        return response()->json([
            'data' => $automate
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description_short' => 'required|string|max:255',
            'description' => 'nullable|json',
            'command' => 'nullable|string',
            'status' => 'nullable|integer',
            'project_id' => 'required|integer|exists:projects,id',
        ]);

        $automate = new AutomateEntity();
        $automate->name = $validatedData['name'];
        $automate->type = $validatedData['type'];
        $automate->description_short = $validatedData['description_short'];
        if (isset($validatedData['description']))
            $automate->description = $validatedData['description'];
        if (isset($validatedData['status']))
            $automate->status = $validatedData['status'];
        if (isset($validatedData['command']))
            $automate->command = $validatedData['command'];
        $automate->folder = 'automate-' . now()->format('YmdHis');
        $automate->project_id = $validatedData['project_id'];

        $automate->save();

        $folder = $automate->folder;
        Storage::disk('private')->makeDirectory($folder);
        Storage::disk('public')->makeDirectory($folder);

        return response()->json([
            'message' => 'Automate created successfully.',
            'data' => $automate
        ], 201);
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
            'status' => 'nullable|integer',
        ]);

        $automate = AutomateEntity::findOrFail($id);
        
        if (isset($validatedData['name']))
            $automate->name = $validatedData['name'];
    
        if (isset($validatedData['description_short']))
            $automate->description_short = $validatedData['description_short'];
    
        if (isset($validatedData['description']))
            $automate->description = $validatedData['description'];

        if (isset($validatedData['status']))
            $automate->status = $validatedData['status'];
    
        if (isset($validatedData['type']))
            $automate->type = $validatedData['type'];
    
        if (isset($validatedData['command']))
            $automate->command = $validatedData['command'];

        $automate->save();

        return response()->json([
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

        if ($automate->folder)
        {
            Storage::disk('public')->deleteDirectory($automate->folder);
            Storage::disk('private')->deleteDirectory($automate->folder);
        }

        return response()->json([
            'message' => 'Automate deleted successfully.'
        ], 200);
    }
}
