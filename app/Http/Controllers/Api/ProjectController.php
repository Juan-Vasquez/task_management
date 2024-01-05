<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;

class ProjectController extends Controller
{

    public function index()
    {
        $projects = Project::all();

        return ProjectResource::collection($projects);
    }

    public function show(Project $project)
    {
        return ProjectResource::make($project);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'user_id' => ['required']
        ]);

        $project = Project::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'user_id' => $request->input('user_id')
        ]);

        return ProjectResource::make($project);
    }

}