<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransacaoService;
use App\Http\Requests\TransacaoRequest;
use App\Http\Resources\TransacaoResource;

class TransacaoController extends Controller
{
    protected TransacaoService $service;

    public function __construct(TransacaoService $transacaoService)
    {
        $this->service = $transacaoService;  
    }

    /**
     * Display a listing of the resource.
     *
     * @return App\Http\Resources\TransacaoResource
     */
    public function index() 
    {
        $response = $this->service->findAll();
        return TransacaoResource::getInstance($response)->response()->setStatusCode($response['status']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\TransacaoRequest  $request
     * @return App\Http\Resources\TransacaoResource
     */
    public function store(TransacaoRequest $request)
    {
        $transacao = $request->all();
        $response = $this->service->create($transacao);
        return TransacaoResource::getInstance($response)->response()->setStatusCode($response['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return App\Http\Resources\TransacaoResource
     */
    public function show($id)
    {
        $response = $this->service->findById($id);
        return TransacaoResource::getInstance($response)->response()->setStatusCode($response['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return App\Http\Resources\TransacaoResource
     */
    public function destroy($id)
    {
        $response = $this->service->delete($id);
        return TransacaoResource::getInstance($response)->response()->setStatusCode($response['status']);
    }
}
