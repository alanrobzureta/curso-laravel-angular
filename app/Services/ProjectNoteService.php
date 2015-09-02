<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Validators\ProjectNoteValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Description of ProjectService
 *
 * @author Alan
 */
class ProjectNoteService {

    /**
     * @var ProjectValidator
     */
    protected $validator;

    /**
     * @var ProjectRepository
     */
    protected $repository;

    /**
     * 
     * @param ProjectRepository $repository
     * @param ProjectValidator $validator
     */ 
    public function __construct(ProjectNoteRepository $repository, ProjectNoteValidator $validator) 
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
    
    public function update($data = [],$id, $noteId) {
        try {
            $this->validator->with($data)->setId($id)->passesOrFail();
            return $this->repository->update($data, $noteId);
        } catch (ValidatorException $e) {
            return response()->json([
                'error'=>true,
                'message'=>$e->getMessageBag()
            ]);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'error'=>true,  
                'message1'=>$e->getMessage(),
                'message2'=>'Project Note ID '.$id.' nao encontrado.'
            ]);
        }       
    }
    
    public function show($id,$noteId) {
        try {            
            return $this->repository->findWhere(['project_id'=>$id,'id'=>$noteId]);            
        } catch (ValidatorException $e) {
            return response()->json([
                'error'=>true,
                'message'=>$e->getMessageBag()
            ]);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'error'=>true,  
                'message1'=>$e->getMessage(),
                'message2'=>'Project Note ID '.$noteId.' nao encontrado.'
            ]);
        }          
    }
    
    public function destroy($noteId) {
        try {            
            $this->repository->delete($noteId);             
        } catch (ValidatorException $e) {
            return response()->json([
                'error'=>true,
                'message'=>$e->getMessageBag()
            ]);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'error'=>true,  
                'message1'=>$e->getMessage(),
                'message2'=>'Project Note ID '.$noteId.' nao encontrado.'
            ]);
        }         
    }
}
