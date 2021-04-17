<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Conta;
use App\Models\Transacao;

class TransacaoTest extends TestCase
{
    /**
     * Teste encontrar todas as transacoes
     *
     * /transacoes [GET]
     * @return void
     */
    public function testShouldReturnAllContas(){
        $response = $this->call('GET', 'api/transacoes');
        $this->assertEquals(200, $response->original['status']);
    }
    
    /**
     * Uma transacao deve ser retornada
     * /transacoes/id [GET]
     * @return void
     */
    public function testShouldReturnConta() {
        $conta = Conta::factory()->create()->toArray();
        $transacao = Transacao::factory(['conta_id' => $conta['id']])->create();
        $response = $this->call('GET', 'api/transacoes/'.$transacao->id);

        $this->assertEquals(200, $response->original['status']);
    }
    /**
     * Não deve retornar uma transacao
     * /transacoes/id [GET]
     * @return void
     */
    public function testNotFoundTransactionReturn() {
        $response = $this->call('GET', 'api/transacoes/999999');
        $this->assertEquals(400, $response->original['status']);
    }

    /**
     * Deve criar uma transacao de credito (Deposito)
     * /transacoes [POST]
     * @return void
     */
    public function testShouldCreateATransactionOfCredit() {
        $conta = Conta::factory()->create(['valor' => 50])->toArray();
        $transacao = Transacao::factory([
            'numeroConta' => $conta['numero'],
            'valor' => 25,
            'tipo' => 'deposito'
            ])->make()->toArray();

        $response = $this->call('POST', 'api/transacoes', $transacao);
        $this->assertEquals($conta['valor'] + 25, $response->original['conta']['valor']);
        $this->assertEquals(200, $response->original['status']);
    }

    /**
     * Deve criar uma transação de debito (Saque)
     * /transacoes [POST]
     * @return void
     */
    public function testShouldCreateATransactionOfDebit() {
        $conta = Conta::factory()->create(['valor' => 50])->toArray();
        $transacao = Transacao::factory([
            'numeroConta' => $conta['numero'],
            'valor' => 25,
            'tipo' => 'saque'
            ])->make()->toArray();

        $response = $this->call('POST', 'api/transacoes', $transacao);
        $this->assertEquals($conta['valor'] - 25, $response->original['conta']['valor']);
        $this->assertEquals(200, $response->original['status']);
    }

    /**
     * Deve criar uma transação de debito (Saque)
     * /transacoes [POST]
     * @return void
     */
    public function testNotShouldCreateATransaction() {
        Conta::factory()->create()->toArray();
        $transacao = Transacao::factory([
            'numeroConta' => '958884',
            'valor' => 25,
            'tipo' => 'saque'
            ])->make()->toArray();

        $response = $this->call('POST', 'api/transacoes', $transacao);
        $this->assertEquals(400, $response->original['status']);
    }


    /**
     * Uma transação deve ser deletada
     * /transacoes/id [DELETE]
     * @return void
     */
    public function testShouldDeleteConta(){
        $conta = Conta::factory()->create()->toArray();
        $transacao = Transacao::factory(['conta_id' => $conta['id']])->create();

        $response = $this->call('DELETE', 'api/transacoes/'.$transacao->id);
        $this->assertEquals(200, $response->original['status']);
    }
    /**
     * Não deve deletar uma transação, pois ela não existe
     * /transacoes/id [DELETE]
     * @return void
     */
    public function testNotShouldDeleteConta(){
        $response = $this->call('DELETE', 'api/transacoes/999999999');
        $this->assertEquals(400, $response->original['status']);
    }

}
