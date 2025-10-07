<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Log;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $classes = SchoolClass::with('students')->get();

        return response()->json($classes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'required|string|max:10',
            'max_students' => 'required|integer|min:1',
        ]);

        $schoolClass = SchoolClass::create($validatedData);

        return response()->json($schoolClass, 201); // can also do the validation in a new request file
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $schoolClass = SchoolClass::findOrFail($id);

        $schoolClass->load('students');

        return response()->json($schoolClass);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolClass $schoolClass, $id)
    {
        // Log::info('SchoolClass update method was called!');
        $schoolClass = SchoolClass::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'section' => 'sometimes|required|string|max:10',
            'max_students' => 'sometimes|required|integer|min:1',
        ]);

        $schoolClass->update($validatedData);

        return response()->json($schoolClass);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $schoolClass = SchoolClass::findOrFail($id);

        $schoolClass->delete();

        return response()->noContent(); 
    }
}
