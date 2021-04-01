<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSold extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product = Product::where('id', $this->product_id)->first();
        return [
            'product' => $product->name." ( ".$product->info. " )",
            'quantity' => $this->quantity,
            'price' => $this->quantity * $product->unit_price
        ];
    }
}
