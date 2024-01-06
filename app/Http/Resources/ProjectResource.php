<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\JsonApi\JsonApiResources;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{

    use JsonApiResources;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        if ( $request->filled('include') ){

            $this->with['included'] = $this->getIncludes();

        }

        return [
            'title' => $this->resource->title,
            'description' => $this->resource->description,
            'user_id' => $this->resource->user_id
        ];
    }

    public function getIncludes(): array
    {
        return [
            UserResource::make($this->resource->user)
        ];
    }


}
