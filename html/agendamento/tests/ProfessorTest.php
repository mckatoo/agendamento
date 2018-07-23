<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Professor;
use App\User;
use Illuminate\Support\Facades\Crypt;

class ProfessorTest extends TestCase
{
    use DatabaseTransactions;

    public $dados = [];
    public $login = [];
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->dados = [
            'professor' => 'Professor 01' . date('Ymdis') . ' ' . rand(1, 100)
        ];
        $this->login = User::all()[rand(0, User::all()->count() - 1)];
    }

    public function testLoginProfessorname()
    {
        $this->post('/api/login', [
            'email' => '',
            'username' => $this->login->username,
            'password' => Crypt::decrypt($this->login->password)
        ]);
        $this->assertResponseOK();
        // print_r('/////// - LOGIN COM USUARIO ' . $this->login->username . ' - ///////////');

        $resposta = (array)json_decode($this->response->content());
        $this->assertArrayHasKey('remember_token', $resposta);
    }
    
    public function testCreateProfessor()
    {
        $this->post('/api/professor', $this->dados, ['remember_token' => $this->login->remember_token]);
        $this->assertResponseOK();

        $resposta = (array)json_decode($this->response->content());

        $this->assertArrayHasKey('id', $resposta);
        $this->assertArrayHasKey('professor', $resposta);

        $this->seeInDatabase('professores', [
            'professor' => $this->dados['professor'],
        ]);
    }

    // public function testIdProfessor()
    // {
    //     $professor = Professor::first();
    //     $this->get('/api/professor/' . $professor->id, ['remember_token' => $this->login->remember_token]);
    //     $this->assertResponseOk();
    //     $resposta = (array)json_decode($this->response->content());

    //     $this->assertArrayHasKey('id', $resposta);
    //     $this->assertArrayHasKey('name', $resposta);
    //     $this->assertArrayHasKey('email', $resposta);
    // }

    // public function testUpdateProfessorNoPassword()
    // {
    //     $professor = Professor::first();
    //     $dados = [
    //         'name' => 'Nome 01' . date('Ymdis') . ' ' . rand(1, 100),
    //         'professorname' => 'usuario' . date('Ymdis') . ' ' . rand(1, 100),
    //         'email' => 'email4_' . date('Ymdis') . '_' . rand(1, 100) . '@exemplo.com',
    //     ];
    //     $this->put('/api/professor/' . $professor->id, $dados, ['remember_token' => $this->login->remember_token]);
    //     $this->assertResponseOk();
    //     $resposta = (array)json_decode($this->response->content());
    //     $this->assertArrayHasKey('id', $resposta);
    //     $this->assertArrayHasKey('professor', $resposta);
    //     $this->notSeeInDatabase('professors', [
    //         'id' => $professor->id,
    //         'professor' => $professor->professor
    //     ]);
    // }

    // public function testUpdateProfessorWithPassword()
    // {
    //     $professor = Professor::first();
    //     $this->put('/api/professor/' . $professor->id, $this->dados, ['remember_token' => $this->login->remember_token]);
    //     $this->assertResponseOk();
    //     $resposta = (array)json_decode($this->response->content());
    //     $this->assertArrayHasKey('id', $resposta);
    //     $this->assertArrayHasKey('professor', $resposta);
    //     $this->notSeeInDatabase('users', [
    //         'id' => $user->id,
    //         'professor' => $user->name
    //     ]);
    // }

    // public function testDeleteProfessor()
    // {
    //     $professor = Professor::first();
    //     $this->delete('/api/professor/' . $professor->id, ['remember_token' => $this->login->remember_token]);
    //     $this->assertResponseOk();
    //     $this->assertEquals("Removido com sucesso!", $this->response->content());
    // }

    // public function testAllProfessor()
    // {
    //     $this->get('/api/professor', ['remember_token' => $this->login->remember_token]);
    //     $this->assertResponseOk();
    //     $this->seeJsonStructure([
    //         '*' => [
    //             'id',
    //             'professor'
    //         ]
    //     ]);
    // }

    // public function testNameProfessor()
    // {
    //     $this->get('/api/professor/name/nome', ['remember_token' => $this->login->remember_token]);
    //     $this->assertResponseOk();
    //     $this->seeJsonStructure([
    //         '*' => [
    //             'id',
    //             'professor'
    //         ]
    //     ]);
    // }
}
