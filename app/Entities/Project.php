<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'owner_id',
        'client_id',
        'name',
        'description',
        'progress',
        'status',
        'due_date'
    ];

    public function owner()
    {
        return $this->belongsTo('CodeProject\Entities\User');
    }
    
    public function client()
    {
        return $this->belongsTo('CodeProject\Entities\Client');
    }
    
    public function notes() {
        return $this->hasMany(ProjectNote::class);
    }
    
    public function task() {
        return $this->hasMany(ProjectTask::class);
    }
    
    public function members()
    {
        return $this->belongsToMany('CodeProject\Entities\User','project_members');
    }
    
    public function files() {
        return $this->hasMany(ProjectFile::class);
    }
}
