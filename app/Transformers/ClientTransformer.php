<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Transformers;


use CodeProject\Entities\Client;
use League\Fractal\TransformerAbstract;
/**
 * Description of ProjectTransformer
 *
 * @author alan.gomes
 */
class ClientTransformer extends TransformerAbstract
{

    public function transform(Client $client)
    {
        return [
            'client_id' => $client->id,
            'nome' => $client->name,
            'responsavel'=> $client->responsible,
            'email' => $client->email,
            'telefone' => $client->phone,
            'endereco' => $client->address,
            'obs' => $client->obs,
           
        ];
    }
    
}
