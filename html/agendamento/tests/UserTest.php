<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\User;
use Illuminate\Support\Facades\Crypt;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public $dados = [];
    public $login = [];
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $password = str_random(10);
        $this->dados = [
            'name' => 'Nome 01' . date('Ymdis') . ' ' . rand(1, 100),
            'username' => 'user01' . date('Ymdis') . ' ' . rand(1, 100),
            'email' => 'email' . date('Ymdis') . '_' . rand(1, 100) . '@teste.com',
            'password' => $password,
            'password_confirmation' => $password
        ];
        $this->login = User::all()[rand(0, User::all()->count() - 1)];
    }

    public function testLoginUsername()
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

    public function testLoginEmail()
    {
        $this->post('/api/login', [
            'email' => $this->login->email,
            'username' => '',
            'password' => Crypt::decrypt($this->login->password)
        ]);
        // print_r('/////// - LOGIN COM EMAIL ' . $this->login->email . ' - ///////////');
        $this->assertResponseOK();

        $resposta = (array)json_decode($this->response->content());
        $this->assertArrayHasKey('remember_token', $resposta);
    }

    public function testCreateUser()
    {
        $this->post('/api/user', $this->dados, ['remember_token' => $this->login->remember_token]);
        $this->assertResponseOK();

        $resposta = (array)json_decode($this->response->content());

        $this->assertArrayHasKey('id', $resposta);
        $this->assertArrayHasKey('username', $resposta);
        $this->assertArrayHasKey('name', $resposta);
        $this->assertArrayHasKey('email', $resposta);

        $this->seeInDatabase('users', [
            'name' => $this->dados['name'],
            'username' => $this->dados['username'],
            'email' => $this->dados['email']
        ]);
    }

    public function testIdUser()
    {
        $user = User::first();
        $this->get('/api/user/' . $user->id, ['remember_token' => $this->login->remember_token]);
        $this->assertResponseOk();
        $resposta = (array)json_decode($this->response->content());

        $this->assertArrayHasKey('id', $resposta);
        $this->assertArrayHasKey('name', $resposta);
        $this->assertArrayHasKey('email', $resposta);
    }

    public function testUpdateUserNoPassword()
    {
        $user = User::first();
        $dados = [
            'name' => 'Nome 01' . date('Ymdis') . ' ' . rand(1, 100),
            'username' => 'usuario' . date('Ymdis') . ' ' . rand(1, 100),
            'email' => 'email4_' . date('Ymdis') . '_' . rand(1, 100) . '@exemplo.com',
        ];
        $this->put('/api/user/' . $user->id, $dados, ['remember_token' => $this->login->remember_token]);
        $this->assertResponseOk();
        $resposta = (array)json_decode($this->response->content());
        $this->assertArrayHasKey('name', $resposta);
        $this->assertArrayHasKey('username', $resposta);
        $this->assertArrayHasKey('email', $resposta);
        $this->assertArrayHasKey('id', $resposta);
        $this->notSeeInDatabase('users', [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'id' => $user->id
        ]);
    }

    public function testUpdateUserWithPassword()
    {
        $user = User::first();
        $this->put('/api/user/' . $user->id, $this->dados, ['remember_token' => $this->login->remember_token]);
        $this->assertResponseOk();
        $resposta = (array)json_decode($this->response->content());
        $this->assertArrayHasKey('name', $resposta);
        $this->assertArrayHasKey('username', $resposta);
        $this->assertArrayHasKey('email', $resposta);
        $this->assertArrayHasKey('id', $resposta);
        $this->notSeeInDatabase('users', [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'id' => $user->id
        ]);
    }

    public function testDeleteUser()
    {
        $user = User::first();
        $this->delete('/api/user/' . $user->id, ['remember_token' => $this->login->remember_token]);
        $this->assertResponseOk();
        $this->assertEquals("Removido com sucesso!", $this->response->content());
    }

    public function testAllUser()
    {
        $this->get('/api/user', ['remember_token' => $this->login->remember_token]);
        $this->assertResponseOk();
        $this->seeJsonStructure([
            '*' => [
                'id',
                'name',
                'username',
                'email'
            ]
        ]);
    }

    public function testNameUser()
    {
        $this->get('/api/user/name/nome', ['remember_token' => $this->login->remember_token]);
        $this->assertResponseOk();
        $this->seeJsonStructure([
            '*' => [
                'id',
                'name',
                'email'
            ]
        ]);
    }
}
