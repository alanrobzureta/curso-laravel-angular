<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ProjectRepositoryEloquent;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Symfony\Component\HttpFoundation\Response;

class ProjectFileController extends Controller
{

    /**
     * @var ProjectRepositoryEloquent
     */
    private $acl;

    /**
     * @var ProjectService
     */
    private $service;

    /**
     * @var ProjectRepository
     */
    private $repository;
    
    /**
     * 
     * @param ProjectRepository $repository
     * @param ProjectService $service
     */
    public function __construct(ProjectRepository $repository, ProjectService $service, ProjectRepositoryEloquent $acl) {
        
        $this->repository = $repository;
        $this->service = $service;
        $this->acl = $acl;
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|max:10000|mimes:pdf',            
        ]);

        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $name = $file->getClientOriginalName();
        $data['file'] = $file;
        $data['extension'] = $extension;
        //$data['name'] = $request->name;
        $data['name'] = $name;
        $data['project_id'] = $request->project_id;
        $data['description'] = $request->description;
        
        $this->service->createFile($data);      
        
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($projectId,$id) {
        if($this->checkProjectPermissions($projectId) == false){
            return ['error'=>'Access Forbidden'];
        }
        return $this->service->destroyFile($projectId,$id);
    }
    
   private function checkProjectOwner($projectId) {
        $userId = Authorizer::getResourceOwnerId();  
        return $this->acl->isOwner($projectId,$userId);
    }
    
    private function checkProjectMember($projectId) {
        $userId = Authorizer::getResourceOwnerId();       
        return $this->acl->hasMember($projectId,$userId);
    }
    
    private function checkProjectPermissions($projectId) {        
        if($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId)){
            return true;
        }
        return false;
    }
}
