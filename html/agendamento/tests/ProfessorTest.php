<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\User;
use App\Professor;

class ProfessorTest extends TestCase
{
    use DatabaseTransactions;

    public $dados = [];
    public $dadosLogin = [];
    public $api_token = [];
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->dados = [
            'professor' => 'Professor 01' . date('Ymdis') . ' ' . rand(1, 100),
        ];
        $this->dadosLogin = [
            'name' => 'Nome 01' . date('Ymdis') . ' ' . rand(1, 100),
            'email' => 'email' . date('Ymdis') . '_' . rand(1, 100) . '@teste.com',
            'password' => '123',
            'password_confirmation' => '123',
        ];
        $this->api_token = ['api_token' => User::where('api_token', '<>', '')->first()->api_token];
    }

    public function testLogin()
    {
        $this->post('/api/user', $this->dadosLogin, $this->api_token); //UserController@store
        $this->assertResponseOK();

        $this->post('/api/login', $this->dadosLogin); //UserController@login
        $this->assertResponseOK();

        $resposta = (array)json_decode($this->response->content());
        $this->assertArrayHasKey('api_token', $resposta);
    }
    
    public function testCreateProfessor()
    {
        $this->post('/api/professor', $this->dados);
        $this->assertResponseOK();
        
        // $resposta = (array)json_decode($this->response->content());

        // $this->assertArrayHasKey('id', $resposta);
        // $this->assertArrayHasKey('professor', $resposta);

        // $this->seeInDatabase('professor', [
        //     'professor' => $this->dados['professor'],
        // ]);
    }

    // public function testIdProfessor()
    // {
    //     $professor = Professor::first();
    //     $this->get('/api/professor/' . $user->id, $this->api_token);
    //     $this->assertResponseOk();
    //     $resposta = (array)json_decode($this->response->content());

    //     $this->assertArrayHasKey('id', $resposta);
    //     $this->assertArrayHasKey('name', $resposta);
    //     $this->assertArrayHasKey('email', $resposta);
    // }

    // public function testUpdateProfessor()
    // {
    //     $user = User::first();
    //     $dados = [
    //         'name' => 'Nome 01' . date('Ymdis') . ' ' . rand(1, 100),
    //         'email' => 'email4_' . date('Ymdis') . '_' . rand(1, 100) . '@exemplo.com',
    //     ];
    //     $this->put('/api/user/' . $user->id, $dados, $this->api_token);
    //     $this->assertResponseOk();
    //     $resposta = (array)json_decode($this->response->content());
    //     $this->assertArrayHasKey('name', $resposta);
    //     $this->assertArrayHasKey('email', $resposta);
    //     $this->assertArrayHasKey('id', $resposta);
    //     $this->notSeeInDatabase('users', [
    //         'name' => $user->name,
    //         'email' => $user->email,
    //         'id' => $user->id
    //     ]);
    // }

    // public function testDeleteProfessor()
    // {
    //     $user = User::first();
    //     $this->delete('/api/user/' . $user->id, $this->api_token);
    //     $this->assertResponseOk();
    //     $this->assertEquals("Removido com sucesso!", $this->response->content());
    // }

    // public function testAllProfessor()
    // {
    //     $this->get('/api/user', $this->api_token);
    //     $this->assertResponseOk();
    //     $this->seeJsonStructure([
    //         '*' => [
    //             'id',
    //             'name',
    //             'email'
    //         ]
    //     ]);
    // }

    // public function testNameProfessor()
    // {
    //     $this->get('/api/user/name/nome', $this->api_token);
    //     $this->assertResponseOk();
    //     $this->seeJsonStructure([
    //         '*' => [
    //             'id',
    //             'name',
    //             'email'
    //         ]
    //     ]);
    // }
}
