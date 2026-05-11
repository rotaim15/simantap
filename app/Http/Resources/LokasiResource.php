<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class LokasiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
        return [
            'id'          => $this->id,
            'nama_lokasi' => $this->nama_lokasi,
            'alamat'      => $this->alamat,
            'koordinat'   => $this->koordinat,
            'kapasitas'   => $this->kapasitas,
            'keterangan'  => $this->keterangan,
            'status'      => $this->status,
            'jumlah_agenda' => $this->whenCounted('agenda'),
            'created_by'  => $this->whenLoaded('createdBy', fn() =>  $this->createdBy->name),
            'created_at'  => $this->created_at?->format('Y-m-d H:i'),
            'updated_at'  => $this->updated_at?->format('Y-m-d H:i'),
        ];
    }
}
