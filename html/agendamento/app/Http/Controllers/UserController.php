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
        $user = new \App\User($request->all());
        $user->save();

        return $user;
    }
}
