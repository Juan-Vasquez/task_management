<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\ProjectService;

class ProjectController extends Controller
{

    private $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {
        return $this->projectService->index();
    }

    public function show($project)
    {
        return $this->projectService->show($project);
    }
    
    public function store(Request $request)
    {
        return $this->projectService->store($request);
    }

    public function update(Project $project, Request $request)
    {
        return $this->projectService->update($project, $request);
    }

    public function destroy($project)
    {
        return $this->projectService->destroy($project);
    }

}