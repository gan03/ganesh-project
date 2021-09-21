<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Producta;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Session;
class ProductController extends Controller
{
    
    function index(){
        $data = Producta::all();
        return view('product',['products'=>$data]);
    }
    function details($id){
        $data= Producta::find($id);
        return view('details',['product'=>$data]);
    
    }
    function search(Request $req){
        $data = Producta::where('name', 'like','%'.$req->input('query').'%')->get();
        return view('search',['products'=>$data]);


    }
    function addtocart(Request $req){
        
        if ($req->session()->has('user')) {
           $cart =new Cart;
           $cart->user_id=$req->session()->get('user')['id'];
           $cart->product_id=$req->product_id;
           $cart->save();
           return redirect('/');



         }
         else{
             return redirect('login');
         }
    }
   static function cartitem(){
        $user_id=Session::get('user')['id'];
        return Cart::where('user_id',$user_id)->count();

    }
    function cartlist()
    {
        $userId= Session::get('user')['id'];
       $data=  DB::table('cart')
         ->join('productas','cart.product_id','productas.id')
         ->select('productas.*','cart.id as cart_id')
         ->where('cart.user_id',$userId)
         ->get();

         return view('cartlist',['products'=>$data]);

    }
    function orderNow(){
        $userId= Session::get('user')['id'];
       $total =  DB::table('cart')
         ->join('productas','cart.product_id','productas.id')
         ->select('productas.*','cart.id as cart_id')
         ->where('cart.user_id',$userId)
         ->sum('productas.price');
         return view('ordernow',['total'=>$total]);

    }
}
