<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class KaryawanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'nmr_induk'     => $this->nmr_induk,
            'nama'          => $this->nama,
            'alamat'        => $this->alamat,
            'tgl_lahir'     => $this->tgl_lahir,
            'tgl_bergabung' => $this->tgl_bergabung,
            'list_cuti'     => CutiResource::collection($this->getcuti),
        ];
    }
}
