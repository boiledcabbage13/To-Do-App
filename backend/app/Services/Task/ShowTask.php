<?php

namespace App\Services\Task;

use App\Models\Task;

class ShowTask {

    /**
     * @param $data
     */
    public function execute($task) : Task
    {
        try {
            return $task;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
