<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'categories' => $this->categories,
            'unit_price' => $this->unit_price,
            'stock' => $this->stock,
            'info' => $this->info,
            'image' => $this->image
        ];
    }
}
