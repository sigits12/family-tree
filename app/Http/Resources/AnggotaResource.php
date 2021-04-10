<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnggotaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'nama'          => $this->nama,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tingkat'       => $this->tingkat,
            'id_orang_tua'  => $this->id_orang_tua
        ];
    }
}
