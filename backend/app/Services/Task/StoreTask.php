<?php

namespace App\Services\Task;

use App\Models\Task;
use Auth;

class StoreTask {

    /**
     * @param $data ['user_id','name','description','status','start_at','end_at']
     */
    public function execute(array $data) : Task
    {
        try {
            $data['user_id'] = Auth::id();
            return Task::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
}
