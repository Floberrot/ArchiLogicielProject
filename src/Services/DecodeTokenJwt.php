<?php

namespace App\Services;

use Exception;
use Firebase\JWT\JWT;

/**
 * Ce service permet de récupérer les données du formulaire et de structurer le tableau au format attendu
 * Class SetResultFrontIntoArray
 * @package App\Services
 * @return array
 */
class DecodeTokenJwt
{
    public function decodeJwt($token) :array
    {
        
        $jwt = explode(' ', $token['token']);
        $decryptJwt = $jwt[1];
        $decode = JWT::decode($decryptJwt, 'secret_key', ['HS256']);
        $destructJwt = [
            'email' => $decode->email,
            'role' => $decode->role
        ];

        return $destructJwt;
    }
}