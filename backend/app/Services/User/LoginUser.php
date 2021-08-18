<?php

namespace App\Services\User;

use App\Models\User;
use Exception;
use Auth;

class LoginUser {

    /**
     * @param $data [email, password]
     */
    public function execute(array $data) : User
    {
        $authenticate = Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        if($authenticate){
            $user = Auth::user();
 
            $user->access_token = $user->createToken('TodoApp')->accessToken; 

            return $user;
        }
        
        throw new Exception('Invalid credentials.');
    }
}
