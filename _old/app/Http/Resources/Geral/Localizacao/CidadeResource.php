<?php

namespace App\Http\Resources\Geral\Localizacao;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CidadeResource
 *
 * @package App\Http\Resources\Dashboard\Localizacao
 */
class CidadeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'uf' => $this->estado->uf
        ];
    }
}
