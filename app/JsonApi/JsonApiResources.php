<?php

namespace App\JsonApi;

use Closure;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

trait JsonApiResources
{
    
    public function getIncludes(): array
    {
        return [];
    }

    public static function collection($resources): AnonymousResourceCollection
    {
        $collection = parent::collection($resources);

        if(request()->filled('include')){

            foreach ($collection->resource as $resource) {
    
                foreach($resource->getIncludes() as $include){
                    $collection->with['included'][] = $include;
                }
    
            }

        }

        return $collection;
    }

    public function jsonPaginate(): Closure
    {
        return function(){
            /** Builder $this */
        };
    }

}
