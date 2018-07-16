<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        //
    }

    public function store(Request $request){
        $this->validate($request, [
            'name'      => 'requered|max:255',
            'email'     => 'requered|unique:users|max:255',
            'password'  => 'requered|max:255',
        ]);
        $user = new \App\User($request->all());
        $user->save();

        return $user;
    }
}
