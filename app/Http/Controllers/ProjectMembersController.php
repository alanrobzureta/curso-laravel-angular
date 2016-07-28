<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepositoryEloquent;
use CodeProject\Services\ProjectMembersService;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use function dd;

class ProjectMembersController extends Controller
{

    /**
     * @var ProjectRepositoryEloquent
     */
    private $acl;

    /**
     * @var ProjectMembersService
     */
    private $service;    
    
    /**
     *
     * @param ProjectMembersService $service
     */
    public function __construct(ProjectMembersService $service, ProjectRepositoryEloquent $acl) {
        $this->service = $service;
        $this->acl = $acl;
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create($id,$memberId)
    {
        if($this->checkProjectPermissions($id) == false){
            return ['error'=>'Access Forbidden'];
        }
        $this->service->addMember($id,$memberId);
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
        }
        return $this->service->show($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id,$memberId) {
        if($this->checkProjectPermissions($id) == false){
            return ['error'=>'Access Forbidden'];
        }
        $this->service->removeMember($id,$memberId);
    }
    
    /**
     * Return true if member in the project
     *
     * @param  int  $id int $member
     * @return Response
     */
    public function is($id,$memberId) {
        dd($this->service->isMember($id,$memberId));
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
