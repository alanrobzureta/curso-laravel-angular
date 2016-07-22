<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Repositories;

use CodeProject\Entities\Project;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Description of ProjectRepositoryEloquent
 *
 * @author Alan
 */
class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
{
    public function model() {
        return Project::class;
    }
    
    public function isOwner($projectId, $userId){
        //dd($projectId);
        if(count($this->findWhere(['id'=>$projectId, 'owner_id'=>$userId]))){
            return true;
        }
        return false;
    }

}
