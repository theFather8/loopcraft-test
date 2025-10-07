<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role; 
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_student(): void
    {
        $admin = Admin::factory()->create();

        $role = Role::create(['name' => 'admin', 'guard_name' => 'api']);
        $admin->assignRole($role);

        $token = $admin->createToken('test-token')->plainTextToken;

        $studentData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'birthdate' => '2010-01-15',
            'grade' => '5th Grade',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/v1/students', $studentData);

        // 3. Assert: Check the response and database
        $response->assertStatus(201) // Assert status is 201 Created
                 ->assertJsonFragment([ // Assert the JSON contains our data
                    'name' => 'John Doe',
                    'email' => 'john.doe@example.com',
                 ]);

        // Assert the student exists in the database
        $this->assertDatabaseHas('students', [
            'email' => 'john.doe@example.com',
        ]);
    }
}
