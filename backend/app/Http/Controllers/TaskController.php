<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Services\Task\GetTasks;
use App\Services\Task\StoreTask;
use App\Services\Task\UpdateTask;
use App\Services\Task\ShowTask;
use App\Services\Task\DestroyTask;
use App\Http\Resources\Task as TaskResource;
use App\Http\Requests\Task\StoreRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, GetTasks $action)
    {
        try {
            $task = $action->execute($request->all());

            return response()->json([
                'data' => TaskResource::collection($task),
                'message' => 'Successfully get tasks.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => null,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, StoreTask $action)
    {
        try {
            $task = $action->execute($request->all());

            return response()->json([
                'data' => new TaskResource($task),
                'message' => 'Successfully store task.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => null,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task, ShowTask $action)
    {
        try {
            $task = $action->execute($task);

            return response()->json([
                'data' => new TaskResource($task),
                'message' => 'Successfully show task.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => null,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
       //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, Task $task, UpdateTask $action)
    {
        try {
            $task = $action->execute($task, $request->all());

            return response()->json([
                'data' => new TaskResource($task),
                'message' => 'Successfully update task.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => null,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task, DestroyTask $action)
    {
        try {
            $task = $action->execute($task);

            return response()->json([
                'data' => $task,
                'message' => 'Successfully remove task.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => null,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
