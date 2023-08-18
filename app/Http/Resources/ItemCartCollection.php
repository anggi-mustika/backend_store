<?php

namespace App\Http\Resources;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemCartCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $barang = Barang::find($this->product_id);

        return [
            'productID' => $this->product_id,
            'SKU' => $barang->sku,
            'price' => $barang->price,
            'Name' => $barang->Name,
            'Quantity' => $this->quantity,
        ];
    }
}
