<?php

namespace App\Http\Controllers\Produk;

use App\Models\Barang;
use App\Models\NewCart;
use App\Models\Checkout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    public function inputcheckout2(Request $request)
    {
        $productId = $request->input('newcart_id');
        $alamat = $request->input('alamat');
        $kode_pos = $request->input('kode_pos');
        $pengiriman = $request->input('pengiriman');
        $quantity = $request->input('ongkir');
        //$quantity = $request->input('total_bayar');

        $product = NewCart::find($productId);
        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan, cek kembali pesanan anda!'], 404);
        }

        $subtotal = $product->sub_total + $quantity;

        $cartItem = new Checkout();
        $cartItem->newcart_id = $productId;
        $cartItem->alamat = $alamat;
        $cartItem->kode_pos = $kode_pos;
        $cartItem->pengiriman = $pengiriman;
        $cartItem->ongkir = $quantity;
        $cartItem->total_bayar = $subtotal;
        $cartItem->save();


        return response()->json([
            'order' => $cartItem,
            'message' => 'Next Step',
        ], 201);
    }
}
