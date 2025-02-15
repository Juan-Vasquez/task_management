<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{

    private $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        return $this->taskService->index();
    }

    public function show($task){
        return $this->taskService->show($task);
    }
    
    public function store(Request $request)
    {
        return $this->taskService->store($request);
    }

}
