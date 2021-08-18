<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use App\Services\Task\GetTasks;
use App\Services\Task\StoreTask;
use App\Services\Task\UpdateTask;
use App\Services\Task\ShowTask;
use App\Services\Task\DestroyTask;
use App\Models\User;
use App\Models\Task;

class TaskTest extends TestCase
{
    protected $user; 

    public function setUp() : void {
        parent::setUp();

        $this->user = User::find(1);

        $this->actingAs($this->user, 'api');
    }

    public function test_get_tasks()
    {
        $data = (new GetTasks)->execute([
            'limit' => 5,
            'q' => 'test'
        ]);
        
        $this->assertTrue(true);
    }

    public function test_store_task()
    {
        (new StoreTask)->execute([
            'name' => 'Test',
            'start_at' => '2021-08-11 10:00:00'
        ]);
        
        $this->assertTrue(true);
    }

    public function test_update_task()
    {
        $task = Task::find(3);

        (new UpdateTask)->execute(
            $task,
            [
                'name' => 'Test',
                'start_at' => '2021-08-11 10:00:00'
            ]
        );
        
        $this->assertTrue(true);
    }

    public function test_show_task()
    {
        $task = Task::find(3);

        (new ShowTask)->execute($task);
        
        $this->assertTrue(true);
    }

    public function test_destroy_task() {
        $task = Task::find(3);

        (new DestroyTask)->execute($task);
        
        $this->assertTrue(true);
    }
}
