<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;

class TaskService
{

    public function index()
    {
        $tasks = Task::all();

        return TaskResource::collection($tasks);
    }

    public function show(Task $task){
        return TaskResource::make($task);
    }
    
    public function store(Request $request)
    {
        
        $task = Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'due_date' => $request->input('due_date'),
            'priority' => $request->input('priority'),
            'completed' => $request->input('completed'),
            'project_id' => $request->input('project_id') 
        ]);

        return TaskResource::make($task);

    }

}