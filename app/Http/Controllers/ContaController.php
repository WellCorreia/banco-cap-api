<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ContaService;
use App\Http\Requests\ContaRequest;
use App\Http\Resources\ContaResource;

class ContaController extends Controller
{
    protected ContaService $service;

    public function __construct(ContaService $contaService)
    {
        $this->service = $contaService;  
    }

    /**
     * Display a listing of the resource.
     *
     * @return App\Http\Resources\ContaResource
     */
    public function index() 
    {
        $response = $this->service->findAll();
        return ContaResource::getInstance($response)->response()->setStatusCode($response['status']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ContaRequest  $request
     * @return App\Http\Resources\ContaResource
     */
    public function store(ContaRequest $request)
    {
        $conta = $request->all();
        $response = $this->service->create($conta);
        return ContaResource::getInstance($response)->response()->setStatusCode($response['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return App\Http\Resources\ContaResource
     */
    public function show($id)
    {
        $response = $this->service->findById($id);
        return ContaResource::getInstance($response)->response()->setStatusCode($response['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $numero
     * @return App\Http\Resources\ContaResource
     */
    public function findByNumeroConta($numero)
    {
        $response = $this->service->findByNumeroConta($numero);
        return ContaResource::getInstance($response)->response()->setStatusCode($response['status']);
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  App\Http\Requests\ContaRequest  $request
    //  * @param  int  $id
    //  * @return App\Http\Resources\ContaResource
    //  */
    // public function update(ContaRequest $request, $id)
    // {
    //     $conta = $request->all();
    //     $response = $this->service->update($conta, $id);
    //     return ContaResource::getInstance($response)->response()->setStatusCode($response['status']);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return App\Http\Resources\ContaResource
     */
    public function destroy($id)
    {
        $response = $this->service->delete($id);
        return ContaResource::getInstance($response)->response()->setStatusCode($response['status']);
    }
}
