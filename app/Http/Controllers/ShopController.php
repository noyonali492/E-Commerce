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

    public function n(Request $request)
{        
	$size = $request->query('size')?$request->query('size'):12;
	$sorting = $request->query('sorting')?$request->query('sorting'):'default';	
	$f_brands = $request->query('brands');	

	if($sorting=='date')   
	{
		$products = Product::where(function($query) use ($f_brands){
								$query->whereIn('brand_id',explode(',',$f_brands))->orWhereRaw("'".$f_brands."' = ''");
							})							
							->orderBy('created_at','DESC')->paginate($size);  
	}
	else if($sorting=="price")
	{
		$products = Product::where(function($query) use ($f_brands){
			$query->whereIn('brand_id',explode(',',$f_brands))->orWhereRaw("'".$f_brands."' = ''");
		})		
		->orderBy('regular_price','ASC')->paginate($size); 
	}
	else if($sorting=="price-desc")
	{
		$products = Product::where(function($query) use ($f_brands){
			$query->whereIn('brand_id',explode(',',$f_brands))->orWhereRaw("'".$f_brands."' = ''");
		})		
		->orderBy('regular_price','DESC')->paginate($size); 
	}
	else{
		$products = Product::where(function($query) use ($f_brands){
			$query->whereIn('brand_id',explode(',',$f_brands))->orWhereRaw("'".$f_brands."' = ''");
		})		
		->paginate($size);  
	}           	
	$brands = Brand::orderBy("name","ASC")->get();
	return view('shop',compact("products","size","sorting","brands","f_brands"));
}  
}
