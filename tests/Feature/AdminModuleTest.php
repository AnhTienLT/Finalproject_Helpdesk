<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use App\Models\Category;
use App\Models\Priority;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminModuleTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $adminRole = Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Technician']);
        Role::create(['name' => 'Employee']);

        $department = Department::create(['name' => 'IT']);

        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id,
            'department_id' => $department->id,
        ]);
    }

    public function test_admin_can_access_user_management()
    {
        $response = $this->actingAs($this->admin)->get(route('users.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_access_role_management()
    {
        $response = $this->actingAs($this->admin)->get(route('roles.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_access_priority_management()
    {
        $response = $this->actingAs($this->admin)->get(route('priorities.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_create_priority()
    {
        $response = $this->actingAs($this->admin)->post(route('priorities.store'), [
            'name' => 'High Priority',
            'level' => 5,
            'color' => '#ff0000',
        ]);

        $response->assertRedirect(route('priorities.index'));
        $this->assertDatabaseHas('priorities', ['name' => 'High Priority']);
    }

    public function test_non_admin_cannot_access_admin_routes()
    {
        $employeeRole = Role::where('name', 'Employee')->first();
        $employee = User::create([
            'name' => 'Employee User',
            'email' => 'employee@example.com',
            'password' => bcrypt('password'),
            'role_id' => $employeeRole->id,
            'department_id' => Department::first()->id,
        ]);

        $response = $this->actingAs($employee)->get(route('users.index'));
        $response->assertStatus(403); // Or whatever logic you have for unauthorized access
    }
}
