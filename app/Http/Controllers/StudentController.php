<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Http\Requests\StoreStudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // eager loading
        $students = Student::with('classes')->get();

        return response()->json($students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request) 
    {
        $validatedData = $request->validated();

        $student = Student::create($validatedData);

        return response()->json($student, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function assignClass(Student $student, SchoolClass $schoolClass)
    {
        // 1. Check if the student is already enrolled in the class
        if ($student->classes->contains($schoolClass)) {
            return response()->json(['message' => 'Student is already enrolled in this class.'], 409);
        }

        // 2. Check if the class has reached its maximum capacity
        if ($schoolClass->students()->count() >= $schoolClass->max_students) {
            return response()->json(['message' => 'Cannot enroll. Class is full.'], 422);
        }

        // 3. Assign the student to the class
        $student->classes()->attach($schoolClass->id);

        return response()->json([
            'message' => 'Student successfully enrolled in class.',
            'student' => $student->load('classes') // Return student with updated classes
        ], 200);
    }
}
