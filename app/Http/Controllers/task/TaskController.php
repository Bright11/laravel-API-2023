<?php

namespace App\Http\Controllers\task;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorTaskRequest;
use App\Http\Resources\TaskResouces;
use App\Models\Task;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use HttpResponse;
    public function index()
    {
        //

        return TaskResouces::collection(
            Task::where('user_id',Auth::user()->id)->get()
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorTaskRequest $request)
    {
        //
        $request->validated($request->all());
        $task=Task::create([
            'user_id'=>Auth::user()->id,
            'name'=>$request->name,
            'description'=>$request->description,
            'priority'=>$request->priority
        ]);
        return new TaskResouces($task);
    }

    /**
     * Display the specified resource.
     */
    // by id
    public function show(Task $task)
    {
        //
        return $this->isNotAuthorized($task) ? $this->isNotAuthorized($task) : new TaskResouces($task);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        if(Auth::user()->id !== $task->user_id){
            return $this->error('','You are not authorized to make this request',401);
        }
        //updating task
        $task->update($request->all());
        return new TaskResouces($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //deleting task


        return $this->isNotAuthorized($task) ? $this->isNotAuthorized($task) :$task->delete();
    }
    private function isNotAuthorized($task){
        if(Auth::user()->id !== $task->user_id){
            return $this->error('','You are not authorized to make this request',401);
        }
    }
}
