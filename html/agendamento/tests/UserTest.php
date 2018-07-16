<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateUser()
    {
        $dados = [
            'name'      => 'Nome 01',
            'email'     => 'teste011@teste.com',
            'password'  => 'senha01'
        ];

        $this->post('/api/user',$dados);
        $this->assertResponseOK();

        $resposta = (array) json_decode($this->response->content());

        $this->assertArrayHasKey('id',$resposta);
        $this->assertArrayHasKey('name',$resposta);
        $this->assertArrayHasKey('email',$resposta);
    }
}
