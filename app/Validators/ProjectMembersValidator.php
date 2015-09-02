<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

/**
 * Description of ProjectMembersValidator
 *
 * @author Alan
 */
class ProjectMembersValidator extends LaravelValidator {
    
    protected $rules = [
        'project_id' => 'required|integer',
        'user_id' => 'required|integer'             
    ];
}
