<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;

class TransacaoResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!empty($this['message']) && $this['status'] != 500) {
            return [
                $this->collection,
            ];
        }

        return [
            'status' => $this['status'],
            'message' => 'Internal Server Error'
        ];
    }

    public static function getInstance($data){
        return (new TransacaoResource($data));
    }
}
