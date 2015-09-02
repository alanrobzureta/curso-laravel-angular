<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Services\ProjectMembersService;
use Illuminate\Http\Request;

class ProjectMembersController extends Controller
{

    /**
     * @var ProjectMembersService
     */
    private $service;    
    
    /**
     *
     * @param ProjectMembersService $service
     */
    public function __construct(ProjectMembersService $service) {
        $this->service = $service;
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create($id,$memberId)
    {
        $this->service->addMember($id,$memberId);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        return $this->service->show($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id,$memberId) {
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
}
