<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Cart;
use Auth;

class UserController extends Controller
{
    public function index(){
        return view('user.index');
    }

    public function account_orders()
    {
    $orders = Order::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(10);
    return view('user.orders',compact('orders'));
    }

    public function account_order_details($order_id)
    {
            $order = Order::where('user_id',Auth::user()->id)->find($order_id);        
            $orderItems = OrderItem::where('order_id',$order_id)->orderBy('id')->paginate(12);
            $transaction = Transaction::where('order_id',$order_id)->first();
            return view('user.order-details',compact('order','orderItems','transaction'));
    }
}
