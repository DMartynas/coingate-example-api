<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use CoinGate\CoinGate;
use Illuminate\Pagination;
use DB;
use App\Order;

\CoinGate\CoinGate::config(array(
    'environment'               => 'sandbox', // sandbox OR live
    'auth_token'                => 'v3hzDvR7yLaNs7fhNDqnkp7tuqy-tfD8BWuV9Pia',
    'curlopt_ssl_verifypeer'    => FALSE // default is false
));
class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $products = Product::orderBy('title', 'asc')->paginate(4);
        return view('Products.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return view('Products.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function order($id)
    {
        $product = Product::find($id);
        $o = Order::create([
            
            'price_amount' => $product["price"],
            'price_currency' => 'BTC',
            'receive_currency' => 'USD',
            'token' => hash('sha512', 'coingate'.rand()),
            'title' => $product["title"],      
            'description' => $product["body"],
            'status' => 'bar'
            ]);

        $post_params = array(
            'order_id'          => $o->id,
            'price_amount'      => number_format((float) $product["price"], 8),
            'price_currency'    => 'BTC',
            'receive_currency'  => 'EUR',
            'callback_url'      => 'http://localhost:81/coingate_callback?token='.$o->token,
            'cancel_url'        => 'http://localhost:81/failed',
            'success_url'       => 'http://localhost:81/success',
            'title'             => $product["title"].' '.$o->id,
            'description'       => $product["body"],
            'status'            => $o->status
        );

$order = \CoinGate\Merchant\Order::create($post_params);

if ($order) {

return redirect($order->payment_url);
        } else {
        return view('Pages.failed');
        }
    }

    public function callback(Request $request) {
        //
        $order = Order::where('order_id', $request->id)->first();
        $token = $request->input('token'); 
        if ($token == $order->token) {
            $status = NULL;
            if ($request->input('status') == 'paid') {
              if ($request->input('price') >= $order->total_price) {
                $status = 'paid';
              }
            }
            else {
              $status = $request->input('status');
            }
            if (!is_null($status)) {
                DB::table('orders')->where('order_id', $order->order_id)->update(['status'=> $status]);
            }
        }
    }

    public function getStatus(Request $request){
        $status = DB::table('orders')->where('order_id', $request->order_id)->value('status');    
        var_dump($status);
        return view('Products.checkStatus')->with('status', $status);
    }

}
  
