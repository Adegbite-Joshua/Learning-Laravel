<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TasksResource;
use App\Models\Task;
use App\Traits\HttpResponses;
use Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     use HttpResponses;
    public function index()
    {
        return $this->success(TasksResource::collection(Task::where('user_id', Auth::user()->id)->get()), null, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        $request->validated($request->all());

        $task = Task::create([
            "user_id"=> Auth::user()->id,
            "name"=> $request->name,
            "description"=> $request->description,
            "priority"=> $request->priority
        ]);

        return new TasksResource($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        if (Auth::user()->id != $task->user_id) {
            return $this->error("", "You are not authorized to make this request", 403);
        }
        return new TasksResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        if (Auth::user()->id != $task->user_id) {
            return $this->error("", "You are not authorized to make this request", 403);
        }

        $task->update($request->all());

        return new TasksResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if (Auth::user()->id != $task->user_id) {
            return $this->error("", "You are not authorized to make this request", 403);
        }
        $task->delete();

        return response(null, 204);
    }
}
