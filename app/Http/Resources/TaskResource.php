<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->resource->title,
            'description' => $this->resource->description,
            'due_date' => $this->resource->due_date,
            'priority' => $this->resource->priority,
            'completed' => $this->resource->completed,
            'project_id' => $this->resource->project_id
        ];
    }
}
