<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Conta;

class ContaTest extends TestCase
{
    /**
     * Teste encontrar todas as contas
     *
     * /contas [GET]
     * @return void
     */
    public function testShouldReturnAllContas(){
        $response = $this->call('GET', 'api/contas');
        $this->assertEquals(200, $response->original['status']);
    }
    
    /**
     * Uma conta deve ser retornada
     * /contas/id [GET]
     * @return void
     */
    public function testShouldReturnConta() {
        $conta = Conta::factory()->create();
        $response = $this->call('GET', 'api/contas/'.$conta->id);

        $this->assertEquals(200, $response->original['status']);
    }
    /**
     * Não deve retornar uma conta
     * /contas/id [GET]
     * @return void
     */
    public function testNotFoundContaReturn() {
        $response = $this->call('GET', 'api/contas/999999');
        $this->assertEquals(400, $response->original['status']);
    }

    /**
     * Uma conta deve ser criada
     * /contas [POST]
     * @return void
     */
    public function testShouldCreateConta(){
        $conta = Conta::factory()->make()->toArray();
        $response = $this->call('POST', 'api/contas', $conta);

        $this->assertEquals(201, $response->original['status']);
    }

    /**
     * Uma conta não deve ser criada
     * /contas [POST]
     * @return void
     */
    public function testNotShouldCreateContaWithNegativeValue(){
        $conta = Conta::factory()->make(['valor' => -15.20])->toArray();
        $response = $this->call('POST', 'api/contas', $conta);

        $this->assertEquals(400, $response->original['status']);
    }

    // /**
    //  * Uma conta deve ser atualizada
    //  * /contas/id [PUT]
    //  * @return void
    //  */
    // public function testShouldUpdateConta(){
    //     $conta = Conta::factory()->create()->toArray();
    //     $conta['valor'] = 50;

    //     $response = $this->call('PUT', 'api/contas/'.$conta['id'], $conta);
    //     $this->assertEquals(200, $response->original['status']);
    // }
    
    // /**
    //  * Não deve atualizar uma conta, pois ela não existe
    //  * /contas/id [PUT]
    //  * @return void
    //  */
    // public function testNotShouldUpdateConta(){
    //     $conta = Conta::factory()->make()->toArray();

    //     $response = $this->call('PUT', 'api/contas/9999999', $conta);
    //     $this->assertEquals(400, $response->original['status']);
    // }

    /**
     * Uma conta deve ser deletada
     * /contas/id [DELETE]
     * @return void
     */
    public function testShouldDeleteConta(){
        $conta = Conta::factory()->create();

        $response = $this->call('DELETE', 'api/contas/'.$conta->id);
        $this->assertEquals(200, $response->original['status']);
    }
    /**
     * Não deve deletar uma conta, pois ela não existe
     * /contas/id [DELETE]
     * @return void
     */
    public function testNotShouldDeleteConta(){
        $response = $this->call('DELETE', 'api/contas/999999999');
        $this->assertEquals(400, $response->original['status']);
    }
}
