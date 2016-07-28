<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepositoryEloquent;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Symfony\Component\HttpFoundation\Response;
use function dd;

class ProjectTaskController extends Controller
{

    /**
     * @var ProjectRepositoryEloquent
     */
    private $acl;

    /**
     * @var ProjectTaskService
     */
    private $service;

    /**
     * @var ProjectTaskRepository
     */
    private $repository;
    
    /**
     * 
     * @param ProjectTaskRepository $repository
     * @param ProjectTaskService $service
     */
    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service, ProjectRepositoryEloquent $acl) {
        
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
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id,$taskId) {
        if($this->checkProjectPermissions($id) == false){
            return ['error'=>'Access Forbidden'];
        }
        return $this->service->show($id,$taskId);
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
    public function update(Request $request, $id, $taskId) {
        if($this->checkProjectPermissions($id) == false){
            return ['error'=>'Access Forbidden'];
        }
        dd($request->all());
        return $this->service->update($request->all(), $id, $taskId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id,$taskId) {
        if($this->checkProjectPermissions($id) == false){
            return ['error'=>'Access Forbidden'];
        }
        $this->service->destroy($taskId);
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
