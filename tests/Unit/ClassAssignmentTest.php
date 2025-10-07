<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Http\Controllers\StudentController;

class ClassAssignmentTest extends TestCase
{
    use RefreshDatabase; // Resets the database for each test

    protected $controller;

    // This method runs before each test
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new StudentController();
    }

    /**
     * Test that a student can be successfully enrolled in a class with space.
     */
    public function test_student_can_be_enrolled_in_class_with_space(): void
    {
        // 1. Arrange: Create a student and a class with space
        $student = Student::factory()->create();
        $class = SchoolClass::factory()->create(['max_students' => 5]);

        // 2. Act: Call the assignClass method directly
        $response = $this->controller->assignClass($student, $class);

        // 3. Assert: Check the response
        $this->assertEquals(200, $response->getStatusCode());
        
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Student successfully enrolled in class.', $responseData['message']);

        // Assert the relationship exists in the database
        $this->assertTrue($student->classes->contains($class));
    }

    /**
     * Test that a student cannot be enrolled in a full class.
     */
    public function test_student_cannot_be_enrolled_in_a_full_class(): void
    {
        // 1. Arrange: Create a student and a class that is already full
        $student = Student::factory()->create();
        $class = SchoolClass::factory()->create(['max_students' => 0]);

        // 2. Act: Call the assignClass method directly
        $response = $this->controller->assignClass($student, $class);

        // 3. Assert: Check that the correct error response is returned
        $this->assertEquals(422, $response->getStatusCode());
        
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Cannot enroll. Class is full.', $responseData['message']);

        // Assert the relationship does NOT exist in the database
        $this->assertFalse($student->classes->contains($class));
    }

    /**
     * Test that a student cannot be enrolled in the same class twice.
     */
    public function test_student_cannot_be_enrolled_twice_in_same_class(): void
    {
        // 1. Arrange: Create a student and a class, and enroll the student
        $student = Student::factory()->create();
        $class = SchoolClass::factory()->create(['max_students' => 5]);
        $student->classes()->attach($class->id);

        // 2. Act: Try to enroll the student again
        $response = $this->controller->assignClass($student, $class);

        // 3. Assert: Check that the correct error response is returned
        $this->assertEquals(409, $response->getStatusCode());

        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Student is already enrolled in this class.', $responseData['message']); // <-- CORRECT MESSAGE
    }
}