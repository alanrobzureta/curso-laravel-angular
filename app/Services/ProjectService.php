<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Description of ProjectService
 *
 * @author Alan
 */
class ProjectService {

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
    public function __construct(ProjectRepository $repository, ProjectValidator $validator) 
    {
        
        $this->repository = $repository;
        $this->validator = $validator;
    }
    
    public function create(array $data) {
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
    
    public function update($data = [],$id) {
        try {
            $this->validator->with($data)->setId($id)->passesOrFail();
            return $this->repository->update($data, $id);
        } catch (ValidatorException $e) {
            return response()->json([
                'error'=>true,
                'message'=>$e->getMessageBag()
            ]);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'error'=>true,  
                'message1'=>$e->getMessage(),
                'message2'=>'Projeto ID '.$id.' nao encontrado.'
            ]);
        }       
    }
    
    public function show($id) {
        try {            
            $this->repository->with('owner');
            $this->repository->with('client');
            return $this->repository->find($id);            
        } catch (ValidatorException $e) {
            return response()->json([
                'error'=>true,
                'message'=>$e->getMessageBag()
            ]);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'error'=>true,  
                'message1'=>$e->getMessage(),
                'message2'=>'Projeto ID '.$id.' nao encontrado.'
            ]);
        }          
    }
    
    public function destroy($id) {
        try {            
            $this->repository->delete($id);             
        } catch (ValidatorException $e) {
            return response()->json([
                'error'=>true,
                'message'=>$e->getMessageBag()
            ]);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'error'=>true,  
                'message1'=>$e->getMessage(),
                'message2'=>'Projeto ID '.$id.' nao encontrado.'
            ]);
        }         
    }
}
