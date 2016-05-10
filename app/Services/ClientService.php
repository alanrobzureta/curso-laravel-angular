<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Services;

use CodeProject\Repositories\ClientRepository;
use CodeProject\Validators\ClientValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Description of ClientService
 *
 * @author Alan
 */
class ClientService {

    /**
     * @var ClientRepository
     */
    protected $repository;

    /**
     * @var ClientValidator
     */
    protected $validator;
    
    
    public function __construct(ClientRepository $repository, ClientValidator $validator) 
    {    
        $this->repository = $repository;
        $this->validator = $validator;     
    }
    
    public function create(array $data) 
    {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch (ValidatorException $e) {
            return [
                'error'=>true,
                'message' => $e->getMessageBag()
            ];
        }
    }
    
    public function update(array $data,$id) 
    {
        try {
            $this->validator->with($data)->setId($id)->passesOrFail();
            $this->repository->update($data, $id);
        } catch (ValidatorException $e) {
            return [
                'error'   => TRUE,
                'message' => $e->getMessageBag()
            ];
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'error'=>true,  
                'message1'=>$e->getMessage(),
                'message2'=>'Cliente ID '.$id.' nao encontrado.'
            ]);
        }        
    }
    
    public function show($id) {
        try {            
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
                'message2'=>'Cliente ID '.$id.' nao encontrado.'
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
                'message2'=>'Cliente ID '.$id.' nao encontrado.'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'error'=>true,  
                'message1'=>$e->getMessage(),
                'message2'=>'Cliente ID '.$id.' possui projetos atrelados a ele. Primeiro exclua o(s) projeto(s).'
            ]);
        }     
    }
    
}
