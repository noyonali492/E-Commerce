<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Cart;

class WishlistController extends Controller
{

    public function index()
    {
        $cartItems = Cart::instance('wishlist')->content();
        return view('wishlist',compact('cartItems'));
    }


    public function add_to_wishlist(Request $request)
    {
        Cart::instance('wishlist')->add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');
        return redirect()->back();
    }
}
