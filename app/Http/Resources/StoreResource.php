<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $baseUrl = 'https://malomkecskemet.hu/';

        return [
            'id' => $this->id,
            'name' => $this->name,
            'floor' => $this->floor,
            'logo' => $baseUrl . $this->avatar,
            'image' => $baseUrl . $this->path,
            'homepage' => $baseUrl . 'hu/uzlet/' . $this->slug,
            'categories' => $this->categories()->select('name')->get(),
            'email' => $this->email,
            'phone' => $this->phone,
            'description' => strip_tags($this->description),
            'facebook' => $this->socials()->where('icon_name', 'social-facebook')->select('url')->first()->url ?? null,
            'hours' => $this->getOpenHours()
        ];
    }
}
