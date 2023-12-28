<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'priority',
        'completed',
        'project_id'
    ];

    protected $casts = [
        'id' => 'integer',
        'project_id' => 'integer'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
