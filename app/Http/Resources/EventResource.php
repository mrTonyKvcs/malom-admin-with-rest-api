<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $baseUrl = 'https://malomkecskemet.hu/images/offers/';

        return [
            'id' => $this->id,
            'name' => $this->title,
            'date_start' => Carbon::parse($this->started_at)->format('Y-m-d'),
            'date_end' => Carbon::parse($this->finished_at)->format('Y-m-d'),
            'description' => strip_tags($this->description),
            'imageUrl' => $baseUrl . basename($this->path),
            'tnImageUrl' => $baseUrl . basename($this->thumbnail),
            'place' => $this->store->name ?? null
        ];
    }
}
