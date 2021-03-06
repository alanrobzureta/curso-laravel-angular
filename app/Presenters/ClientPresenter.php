<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Presenters;

use CodeProject\Transformers\ClientTransformer;
use Prettus\Repository\Presenter\FractalPresenter;
/**
 * Description of ProjectPresenter
 *
 * @author alan.gomes
 */
class ClientPresenter extends FractalPresenter
{
    public function getTransformer() 
    {
        return new ClientTransformer();
    }
    
}
