<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class TaskTest extends TestCase
{
    protected $user; 

    public function setUp() : void {
        parent::setUp();

        $this->user = User::find(1);

        $this->actingAs($this->user, 'api');
    }

    public function test_get_tasks() {
        $response = $this->get('/api/tasks');

        $response->assertStatus(200);
    }

    public function test_get_tasks_with_search() {
        $response = $this->get('/api/tasks?q=test');

        $response->assertStatus(200);
    }

    public function test_get_tasks_with_pagination() {
        $response = $this->get('/api/tasks?limit=10');

        $response->assertStatus(200);
    }

    public function test_store_task_without_name() {
        $response = $this->postJson('/api/tasks', [
            'start_at' => '2021-08-11 10:00:00'
        ]);

        $response->assertStatus(422);
    }

    public function test_store_task_start_at() {
        $response = $this->postJson('/api/tasks', [
            'name' => 'Test Task',
        ]);

        $response->assertStatus(422);
    }

    public function test_store_task() {
        $response = $this->postJson('/api/tasks', [
            'name' => 'Test Task',
            'start_at' => '2021-08-11 10:00:00'
        ]);

        $response->assertStatus(200);
    }

    public function test_show_task() {
        $response = $this->get('/api/tasks/1');

        $response->assertStatus(200);
    }

    public function test_show_task_non_exsisting() {
        $response = $this->get('/api/tasks/99999');

        $response->assertStatus(404);
    }

    public function test_update_task() {
        $response = $this->putJson('/api/tasks/1', [
            'name' => 'Edited Task',
            'start_at' => '2021-08-11 10:00:00',
            'end_at' => '2021-08-11 11:00:00',
            'description' => 'A test description',
            'status' => 'completed'
        ]);

        $response->assertStatus(200);
    }

    public function test_destroy_task() {
        $response = $this->deleteJson('/api/tasks/1');

        $response->assertStatus(200);
    }
}
