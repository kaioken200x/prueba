<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'description', 'project_id', 'start_datetime', 'end_datetime'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('name', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
