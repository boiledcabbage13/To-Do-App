<?php

namespace App\Services\Task;

use App\Models\Task;

class UpdateTask {

    /**
     * @param $data
     * @param $task Task
     */
    public function execute($task, array $data) : Task
    {
        try {
            $task->name = isset($data['name']) ? $data['name'] : $task->name;
            $task->description = isset($data['description']) ? $data['description'] : $task->description;
            $task->status = isset($data['status']) ? $data['status'] : $task->status;
            $task->start_at = isset($data['start_at']) ? $data['start_at'] : $task->start_at;
            $task->end_at = isset($data['end_at']) ? $data['end_at'] : $task->end_at;
    
            $task->save();
            $task->fresh();
    
            return $task;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
