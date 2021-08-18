<?php

namespace App\Services\Task;

use App\Models\Task;
use Auth;

class GetTasks {

    /**
     * @param $data
     */
    public function execute(array $data)
    {
        try {
            $limit = isset($data['limit']) ? $data['limit'] : 15;

            $q = isset($data['q']) ? $data['q'] : null;

            $model = new Task;

            $model = $model->where('user_id', Auth::id());

            if ($q) {
                $model = $model->where('name', 'LIKE', "%$q%")
                ->orWhere('description', 'LIKE', "%$q%");
            }

            $model = $model->orderBy('start_at', 'asc');

            if ($limit === 'All') {
                return $model->get();
            }

            return $model->paginate($limit);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
