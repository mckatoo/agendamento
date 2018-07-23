<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Professor;
use Illuminate\Http\Response;

class ProfessorController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'professor' => 'required|max:255',
        ]);
        $professor = new Professor($request->all());
        print_r($professor->professor);
        $professor->save();
        return $professor;
    }

    public function update(Request $request, $id)
    {
        $dadosValidacao = [
            'professor' => 'required|max:255',
        ];
        $this->validate($request, $dadosValidacao);
        $professor = Professor::find($id);
        $professor->professor = $request->input('professor');
        $professor->update();
        return $professor;
    }

    public function delete($id)
    {
        Professor::destroy($id)
            ? $response = new Response('Removido com sucesso!', 200)
            : $response = new Response('Erro ao remover!', 401);

        return $response;
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
        return Professor::where('professor', 'like', '%' . $name . '%')->orderBy('professor', 'desc')->get();
    }
}
