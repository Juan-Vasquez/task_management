<?php

namespace App\JsonApi;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class JsonApiQueryBuilder
{

    public function allowedSorts(): Closure
    {

        return function($allowedSorts){

            /** @var Builder $this */
    
            if(request()->filled('sort')){
    
                $sortFields = explode(',', request('sort'));
    
                foreach($sortFields as $sortField){
    
                    $sortDirection = Str::of($sortField)->startsWith('-')
                    ? 'desc'
                    : 'asc';
    
                    $sortField = ltrim($sortField, '-');
    
                    abort_unless( in_array($sortField, $allowedSorts), 400, __('parameter not allowed') );
    
                    $this->orderBy($sortField, $sortDirection);
    
                }
    
            }

            return $this;
        };
    }

    public function allowedFilters(): Closure
    {
        return function($allowedFilters){
            /** @var Builder $this */

            foreach(request('filter', []) as $filter => $value){
                if(!is_null($value)){
                    abort_unless(in_array($filter, $allowedFilters), 400, __("{$filter}, filter not allowed"));

                    $this->{$filter}($value);
                }
            }

            return $this;
        };
    }

    public function jsonPaginate(): Closure
    {
        return function(){
            /** @var Builder $this */
            return $this->paginate(
                $perPage = request('page.size', 15), 
                $columns = ['*'], 
                $pageName = 'page[number]', 
                $page = request('page.number')
            );
        };
    }

    public function sparseFieldset(): Closure
    {
        return function(){
            /** @var Builder $this */
            
            if(request()->isNotFilled('fields')){
                return $this;
            }

            $resourceType = $this->model->getTable();

            if(property_exists($this->model, 'resourceType')){
                $resourceType = $this->model->resourceType;
            }

            $fields = explode(',', request('fields.'.$resourceType));

            return $this->addSelect($fields);
        };
    }

}