<?php

namespace App\Service;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectService
{

    public function index(): AnonymousResourceCollection
    {
        $projects = Project::all();

        return ProjectResource::collection($projects);
    }

    public function show(Project $project): ProjectResource
    {
        return ProjectResource::make($project);
    }

    public function store(Request $request): ProjectResource
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

    public function update(Project $project, Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'user_id' => ['required']
        ]);

        $project->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'user_id' => $request->input('user_id')
        ]);

        return ProjectResource::make($project);
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response()->noContent();
    }

}