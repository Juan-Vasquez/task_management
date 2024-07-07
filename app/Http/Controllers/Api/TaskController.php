<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    
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
