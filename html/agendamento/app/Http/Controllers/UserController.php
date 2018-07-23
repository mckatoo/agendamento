<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $dados = $request->only('email','username','password');
        $user = User::where('username', $dados['username'])->orWhere('email', $dados['email'])->first();
        if (Crypt::decrypt($user->password) == $dados['password']) {
            $user->remember_token = str_random(60);
            $user->update();
            return ['remember_token' => $user->remember_token];
        } else {
            return new Response('Login ou usuário inválido.', 401);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|confirmed|max:255',
        ]);
        $user = new User($request->all());
        $user->password = Crypt::encrypt($request->input('password'));
        $user->remember_token = str_random(60);
        $user->save();
        return $user;
    }

    public function update(Request $request, $id)
    {
        $dadosValidacao = [
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
        ];
        isset($request->all()['password'])
            ? $dadosValidacao['password'] = 'required|confirmed|max:255'
            : null;
        $this->validate($request, $dadosValidacao);
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        isset($request->all()['password'])
            ? $user->password = Crypt::encrypt($request->input('password'))
            : null;
        $user->update();
        return $user;
    }

    public function delete($id)
    {
        User::destroy($id)
            ? $response = new Response('Removido com sucesso!', 200)
            : $response = new Response('Erro ao remover!', 401);

        return $response;
    }

    public function id($id)
    {
        return User::find($id);
    }

    public function all()
    {
        return User::all();
    }

    public function name($name)
    {
        return User::where('name', 'like', '%' . $name . '%')->orderBy('name', 'desc')->get();
    }
}
