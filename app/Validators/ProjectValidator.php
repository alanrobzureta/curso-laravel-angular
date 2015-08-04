<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

/**
 * Description of ProjectValidator
 *
 * @author Alan
 */
class ProjectValidator extends LaravelValidator {
    
    protected $rules = [
        'name' => 'required|max:255',
        'description' => 'required|max:255',
        'progress' => 'required|max:255',
        'status' => 'required',
        'due_date' => 'required'        
    ];
}
