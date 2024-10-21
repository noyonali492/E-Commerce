<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ShopController extends Controller
{
        public function index(Request $request)
    {        
        $size = $request->query('size')?$request->query('size'):12;
        $o_colum = "";
        $o_order = "";
        $order = $request->query('order')? $request->query('order') :-1;

        switch($order)
        {
            case 1:
                $o_colum = 'created_at';
                $o_order= 'DESC'; 
                break ;
            case 2:
                $o_colum = 'created_at';
                $o_order= 'ASC'; 
                break ;
            case 3:
                $o_colum = 'regular_price';
                $o_order='ASC'; 
                break ;
            case 4:
                $o_colum = 'regular_price';
                $o_order= 'DESC'; 
                break ;
            default :
                $o_colum = 'id';
                $o_order='DESC'; 

        }
        $products = Product::orderBy($o_colum,$o_order)->paginate($size);

        return view('shop',compact("products","size","order"));

    } 

    public function product_details($product_slug)
    {
        $product = Product::where("slug",$product_slug)->first();
        $rproducts = Product::where("slug","<>",$product_slug)->get()->take(8);

        return view('details',compact("product","rproducts"));
    }
}
