<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Transformers;


use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;
/**
 * Description of ProjectTransformer
 *
 * @author alan.gomes
 */
class ProjectTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'members',
        'notes',
        'tasks'
    ];

    public function transform(Project $project)
    {
        return [
            'project_id' => $project->id,
            'client_id' => $project->client_id,
            'owner_id' => $project->owner_id,
            'name' => $project->name,
            'description' => $project->description,
            'progress' => $project->progress,
            'status' => $project->status,
            'due_date' => $project->due_date
        ];
    }
    
    public function includeMembers(Project $project) 
    {
        return $this->collection($project->members, new ProjectMemberTransformer());
    }
    
    public function includeNotes(Project $project) 
    {
        return $this->collection($project->notes, new ProjectNoteTransformer());
    }
    
    public function includeTasks(Project $project) 
    {
        return $this->collection($project->task, new ProjectTaskTransformer());
    }
    
}
