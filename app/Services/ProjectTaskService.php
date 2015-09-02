<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Validators\ProjectTaskValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Description of ProjectTaskService
 *
 * @author Alan
 */
class ProjectTaskService {

    /**
     * @var ProjectTaskValidator
     */
    protected $validator;

    /**
     * @var ProjectTaskRepository
     */
    protected $repository;

    /**
     * 
     * @param ProjectTaskRepository $repository
     * @param ProjectTaskValidator $validator
     */ 
    public function __construct(ProjectTaskRepository $repository, ProjectTaskValidator $validator) 
    {
        
        $this->repository = $repository;
        $this->validator = $validator;
    }
    
    public function create($data = []) {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch (ValidatorException $e) {
            return [
                'error'=>true,
                'message'=>$e->getMessageBag()
            ];
        }        
    }
    
    public function update($data = [],$id, $taskId) {
        try {
            $this->validator->with($data)->setId($id)->passesOrFail();
            return $this->repository->update($data, $taskId);
        } catch (ValidatorException $e) {
            return response()->json([
                'error'=>true,
                'message'=>$e->getMessageBag()
            ]);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'error'=>true,  
                'message1'=>$e->getMessage(),
                'message2'=>'Project Task ID '.$taskId.' nao encontrado.'
            ]);
        }       
    }
    
    public function show($id,$taskId) {
        try {            
            return $this->repository->findWhere(['project_id'=>$id,'id'=>$taskId]);            
        } catch (ValidatorException $e) {
            return response()->json([
                'error'=>true,
                'message'=>$e->getMessageBag()
            ]);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'error'=>true,  
                'message1'=>$e->getMessage(),
                'message2'=>'Project Task ID '.$taskId.' nao encontrado.'
            ]);
        }          
    }
    
    public function destroy($taskId) {
        try {            
            $this->repository->delete($taskId);             
        } catch (ValidatorException $e) {
            return response()->json([
                'error'=>true,
                'message'=>$e->getMessageBag()
            ]);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'error'=>true,  
                'message1'=>$e->getMessage(),
                'message2'=>'Project Task ID '.$taskId.' nao encontrado.'
            ]);
        }         
    }
}
