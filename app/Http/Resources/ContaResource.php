<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContaResource extends JsonResource
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
            return parent::toArray($request);
        }

        return [
            'status' => $this['status'],
            'message' => 'Internal Server Error'
        ];
    }

    public static function getInstance($data){
        return (new ContaResource($data));
    }
}