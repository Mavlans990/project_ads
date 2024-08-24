<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CutiResource extends JsonResource
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
            "tgl_cuti"      => $this->tgl_cuti,
            "lama_cuti"     => $this->lama_cuti,
            "keterangan"    => $this->keterangan,
        ];
    }
}
