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
//use Illuminate\Support\Facades\File;
//use Illuminate\Support\Facades\Storage;
use Prettus\Validator\Exceptions\ValidatorException;

use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Filesystem\Filesystem;

/**
 * Description of ProjectService
 *
 * @author Alan
 */
class ProjectService {

    /**
     * @var Storage
     */
    private $storage;

    /**
     * @var Factory
     */
    private $filesystem;

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
    public function __construct(ProjectRepository $repository, ProjectValidator $validator,Filesystem $filesystem,Storage $storage ) 
    {
        
        $this->repository = $repository;
        $this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
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
    
    public function createFile(array $data) 
    {        
        $project = $this->repository->skipPresenter()->find($data['project_id']);        
        $projectFile = $project->files()->create($data);
        $this->storage->put($projectFile->id.".".$data['extension'], $this->filesystem->get($data['file']));
    }
}
