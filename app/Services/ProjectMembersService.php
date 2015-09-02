<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Services;

use CodeProject\Entities\Project;
use CodeProject\Repositories\ProjectMembersRepository;
use CodeProject\Validators\ProjectMembersValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Description of ProjectService
 *
 * @author Alan
 */
class ProjectMembersService {

    /**
     * @var Project
     */
    protected $project;

    /**
     * @var ProjectMembersValidator
     */
    protected $validator;

    /**
     * @var ProjectMembersRepository
     */
    protected $repository;

    /**
     * 
     * @param ProjectMembersRepository $repository
     * @param ProjectMembersValidator $validator
     */ 
    public function __construct(ProjectMembersRepository $repository, ProjectMembersValidator $validator, Project $project) 
    {
        
        $this->repository = $repository;
        $this->validator = $validator;
        $this->project = $project;
    }
    
    public function addMember($project,$member) {
        try {
            return $this->repository->create(['project_id'=>$project,'user_id'=>$member]);
        } catch (ValidatorException $e) {
            return [
                'error'=>true,
                'message'=>$e->getMessageBag()
            ];
        }        
    }
    
    public function show($project) {
        try {            
            $projeto = $this->project->find($project);
            return $projeto->members;            
        } catch (ValidatorException $e) {
            return response()->json([
                'error'=>true,
                'message'=>$e->getMessageBag()
            ]);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'error'=>true,  
                'message1'=>$e->getMessage(),
                'message2'=>'Projeto ID '.$project.' nao encontrado.'
            ]);
        }          
    }
    
    public function removeMember($project,$member) {
        try {            
            $projeto = $this->project->find($project);
            $projeto->members()->detach($member);
            return response()->json([
                'message'=>'Membro '.$member.' removido do projeto '.$project.'.'
            ]);      
        } catch (ValidatorException $e) {
            return response()->json([
                'error'=>true,
                'message'=>$e->getMessageBag()
            ]);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'error'=>true,  
                'message1'=>$e->getMessage(),
                'message2'=>'Projeto ID '.$project.' nao encontrado.'
            ]);
        }         
    }
    
    public function isMember($project,$member) {
        try {            
            $projeto = $this->project->find($project);
            
            foreach ($projeto->members as $m) {
                if($m->id == $member){
                    return true;
                }
            }
            return false;            
        } catch (ValidatorException $e) {
            return response()->json([
                'error'=>true,
                'message'=>$e->getMessageBag()
            ]);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'error'=>true,  
                'message1'=>$e->getMessage(),
                'message2'=>'Projeto ID '.$project.' nao encontrado.'
            ]);
        }          
    }
}
