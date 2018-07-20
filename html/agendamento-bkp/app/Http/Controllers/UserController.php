<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function all(){
        return 'teste';
    }

    public function store(Request $request){
        return [
            'id' => '123',
            'name' => 'Nome 01' . date('Ymdis') . ' ' . rand(1, 100),
            'email' => 'email' . date('Ymdis') . '_' . rand(1, 100) . '@teste.com',
        ];
    }
}