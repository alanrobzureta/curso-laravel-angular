<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Repositories\ProjectRepositoryEloquent;
use CodeProject\Services\ProjectNoteService;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Symfony\Component\HttpFoundation\Response;

class ProjectNoteController extends Controller
{

    /**
     * @var ProjectRepositoryEloquent
     */
    private $acl;

    /**
     * @var ProjectNoteService
     */
    private $service;

    /**
     * @var ProjectNoteRepository
     */
    private $repository;
    
    /**
     * 
     * @param ProjectNoteRepository $repository
     * @param ProjectNoteService $service
     */
    public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service, ProjectRepositoryEloquent $acl) {
        
        $this->repository = $repository;
        $this->service = $service;
        $this->acl = $acl;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {
        if($this->checkProjectPermissions($id) == false){
            return ['error'=>'Access Forbidden'];
        }
        //$this->repository->with('project');
        //return $this->repository->all();
        return $this->repository->findWhere(['project_id'=>$id]);
        
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
        $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id,$noteId) {
        if($this->checkProjectPermissions($id) == false){
            return ['error'=>'Access Forbidden'];
        }
        return $this->service->show($id,$noteId);
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
    public function update(Request $request, $id, $noteId) {
        if($this->checkProjectPermissions($id) == false){
            return ['error'=>'Access Forbidden'];
        }
        return $this->service->update($request->all(), $id, $noteId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id,$noteId) {
        if($this->checkProjectPermissions($id) == false){
            return ['error'=>'Access Forbidden'];
        }
        $this->service->destroy($noteId);
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
