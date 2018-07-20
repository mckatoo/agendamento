<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\User;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public $dados = [];
    public $api_token = [];
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->dados = [
            'name' => 'Nome 01' . date('Ymdis') . ' ' . rand(1, 100),
            'email' => 'email' . date('Ymdis') . '_' . rand(1, 100) . '@teste.com',
            'password' => '123',
            'password_confirmation' => '123',
        ];
        // $this->api_token = ['api_token' => User::where('api_token','<>','')->first()->api_token];
    }

    public function testAll(){
        $this->get('/api/user');
        $this->assertResponseOk();
    }

    // public function testCreateUser()
    // {
        // $this->post('/api/user', $this->dados);
        // $this->assertResponseOK();
        // $resposta = (array)json_decode($this->response->content());

        // $this->assertArrayHasKey('id', $resposta);
        // $this->assertArrayHasKey('name', $resposta);
        // $this->assertArrayHasKey('email', $resposta);

        // $this->post('/api/user', $this->dados, $this->api_token);
        // $this->assertResponseOK();

        // $resposta = (array)json_decode($this->response->content());

        // $this->assertArrayHasKey('id', $resposta);
        // $this->assertArrayHasKey('name', $resposta);
        // $this->assertArrayHasKey('email', $resposta);

        // $this->seeInDatabase('users', [
        //     'name' => $this->dados['name'],
        //     'email' => $this->dados['email']
        // ]);
    // }

    // public function testIdUser()
    // {
    //     $user = User::first();
    //     $this->get('/api/user/' . $user->id, $this->api_token);
    //     $this->assertResponseOk();
    //     $resposta = (array)json_decode($this->response->content());

    //     $this->assertArrayHasKey('id', $resposta);
    //     $this->assertArrayHasKey('name', $resposta);
    //     $this->assertArrayHasKey('email', $resposta);
    // }

    // public function testLogin()
    // {
    //     $this->post('/api/user', $this->dados, $this->api_token);
    //     $this->assertResponseOK();

    //     $this->post('/api/login', $this->dados);
    //     $this->assertResponseOK();

    //     $resposta = (array) json_decode($this->response->content());
    //     $this->assertArrayHasKey('api_token',$resposta);
    // }

    // public function testUpdateUserNoPassword()
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

    // public function testUpdateUserWithPassword()
    // {
    //     $user = User::first();
    //     $this->put('/api/user/' . $user->id, $this->dados, $this->api_token);
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

    // public function testDeleteUser()
    // {
    //     $user = User::first();
    //     $this->delete('/api/user/' . $user->id, $this->api_token);
    //     $this->assertResponseOk();
    //     $this->assertEquals("Removido com sucesso!", $this->response->content());
    // }

    // public function testAllUser()
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

    // public function testNameUser()
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
