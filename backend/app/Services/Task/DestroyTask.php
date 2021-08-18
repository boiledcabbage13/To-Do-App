<?php

namespace App\Services\Task;

use App\Models\Task;

class DestroyTask {

    /**
     * @param $data
     */
    public function execute($task) : bool
    {
        try {
            return $task->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
