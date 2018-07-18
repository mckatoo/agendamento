<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Professor;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;

class ProfessorController extends Controller
{
    public function __construct()
    {
        //
    }

    public function login(Request $request)
    {
        $dados = $request->only('email','password');
        $professor = Professor::where('email',$dados['email'])
            ->first();
        if(Crypt::decrypt($professor->password) === $dados['password']){
            $professor->api_token = str_random(60);
            $professor->update();
            return ['api_token' => $professor->api_token];
        }else{
            return new Response('Login ou usuário inválido.',401);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|unique:professor|max:255',
            'password' => 'required|confirmed|max:255',
        ]);
        $professor = new Professor($request->all());
        $professor->password = Crypt::encrypt($request->input('password'));
        $professor->api_token = str_random(60);
        $professor->save();
        return $professor;
    }

    public function update(Request $request, $id)
    {
        $dadosValidacao = [
            'name' => 'required|max:255',
            'email' => 'required|unique:professor|max:255',
        ];
        isset($request->all()['password'])
            ? $dadosValidacao['password'] = 'required|confirmed|max:255'
            : null;
        $this->validate($request,$dadosValidacao);
        $professor = Professor::find($id);
        $professor->name = $request->input('name');
        $professor->email = $request->input('email');
        isset($request->all()['password'])
            ? $professor->password = Crypt::encrypt($request->input('password'))
            : null;
        $professor->update();
        return $professor;
    }

    public function delete($id){
        Professor::destroy($id)
            ? $response = new Response('Removido com sucesso!', 200)
            : $response = new Response('Erro ao remover!',401);
        
        return $response;
        // if(Professor::destroy($id)){
        //     return new Response('Removido com sucesso!',200);
        // }else{
        //     return new Response('Erro ao remover!',401);
        // }
    }

    public function id($id)
    {
        return Professor::find($id);
    }

    public function all()
    {
        return Professor::all();
    }

    public function name($name)
    {
        return Professor::where('name', 'like', '%'.$name.'%')->orderBy('name','desc')->get();
    }
}
