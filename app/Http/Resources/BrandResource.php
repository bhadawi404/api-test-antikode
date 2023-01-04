<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'brandId' => $this->id,
            'brandName' => $this->name,
            'brandLogo'=>$this->logo,
            'brandBanner'=>$this->banner,

        ];
    }
}
