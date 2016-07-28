<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Repositories;

use CodeProject\Entities\Client;
use CodeProject\Presenters\ClientPresenter;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Description of ClientRepositoryEloquent
 *
 * @author Alan
 */
class ClientRepositoryEloquent extends BaseRepository implements ClientRepository
{
    public function model() 
    {
        return Client::class;
    }
    
    public function presenter()
    {
        return ClientPresenter::class;
    }

//put your code here
}
