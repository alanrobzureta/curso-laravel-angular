<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectFileController extends Controller
{

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
    public function __construct(ProjectRepository $repository, ProjectService $service) {
        
        $this->repository = $repository;
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->repository->with('owner');
        $this->repository->with('client');
        return $this->repository->findWhere(['owner_id'=>Authorizer::getResourceOwnerId()]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        
        $data['file'] = $file;
        $data['extension'] = $extension;
        $data['name'] = $request->name;
        $data['project_id'] = $request->project_id;
        $data['description'] = $request->description;
        
        $this->service->createFile($data);      
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        if($this->checkProjectPermissions($id) == false){
            return ['error'=>'Access Forbidden'];
        };
        
        return $this->service->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        if($this->checkProjectPermissions($id) == false){
            return ['error'=>'Access Forbidden'];
        };
        
        return $this->service->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        if($this->checkProjectPermissions($id) == false){
            return ['error'=>'Access Forbidden'];
        };
        
        $this->service->destroy($id);
    }
    
    private function checkProjectOwner($projectId) {
        $userId = Authorizer::getResourceOwnerId();       
        return $this->repository->isOwner($projectId,$userId);
    }
    
    private function checkProjectMember($projectId) {
        $userId = Authorizer::getResourceOwnerId();       
        return $this->repository->hasMember($projectId,$userId);
    }
    
    private function checkProjectPermissions($projectId) {        
        if($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId)){
            return true;
        }
        return false;
    }
}
