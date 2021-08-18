<?php

namespace App\Services\User;

use App\Models\User;
use Exception;

class StoreUser {

    /**
     * @param $data [name, email, password]
     */
    public function execute(array $data) : User
    {
        $email = $data['email'];

        if(User::where('email', $email)->first()) {
            throw new Exception('Email should be unique.');
        }

        $user = new User;
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->name = $data['name'];
        $user->save();
       
        return $user;
    }
}
