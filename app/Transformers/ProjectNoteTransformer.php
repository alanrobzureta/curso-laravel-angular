<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Transformers;


use CodeProject\Entities\ProjectNote;
use League\Fractal\TransformerAbstract;
/**
 * Description of ProjectTransformer
 *
 * @author alan.gomes
 */
class ProjectNoteTransformer extends TransformerAbstract
{

    public function transform(ProjectNote $note)
    {
        return [
            'note_id' => $note->id,
            'project_id' => $note->project_id,
            'title' => $note->title,
            'note' => $note->note           
        ];
    }
    
}
