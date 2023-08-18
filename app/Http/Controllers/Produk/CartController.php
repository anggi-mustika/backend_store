<?php

namespace App\Http\Controllers\Produk;

use Produk;
use App\Order;

use App\Product;
use App\CartItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ItemCartCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\CartItemCollection as CartItemCollection;

class CartController extends Controller
{

    /**
     * Store a newly created Cart in storage and return the data to the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::guard('api')->check()) {
            $userID = auth('api')->user()->getKey();
        }

        $cart = Cart::create([
            'id' => md5(uniqid(rand(), true)),
            'key' => md5(uniqid(rand(), true)),
            'userID' => isset($userID) ? $userID : null,

        ]);
        return response()->json([
            'Message' => 'A new cart have been created for you!',
            'cartToken' => $cart->id,
            'cartKey' => $cart->key,
        ], 201);
    }

    /**
     * Display the specified Cart.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartKey' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        $cartKey = $request->input('cartKey');
        if ($cart->key == $cartKey) {
            return response()->json([
                'cart' => $cart->id,
                'Items in Cart' => new ItemCartCollection($cart->items),
            ], 200);
        } else {

            return response()->json([
                'message' => 'The CarKey you provided does not match the Cart Key for this Cart.',
            ], 400);
        }
    }
}
