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
    'auth_token'                => 'cYQj-Xz4YMhwrdzunH7ndSwwCNMoAgxo6Z7JTMZi',
    'curlopt_ssl_verifypeer'    => FALSE // default is false
));
class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $products = Product::orderBy('created_at', 'asc')->paginate(4);
        return view('Products.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Product::class);
        $this->validate($request, [
            'planname' => 'required',
            'description' => 'required',
            'price' => 'required'
        ]);

        $product = new Product;
        $product->title = $request->input('planname');
        $product->body = $request->input('description');
        $product->price = $request->input('price');
        $product->save();
        
        return redirect('/products')->with('success', 'Mobile plan created!');

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
        $product = Product::find($id);
        $product->delete();
        return redirect('/products')->with('success', 'Product removed');
    }
    

    public function order($id)
    {
        $product = Product::find($id);
        
        $o = new Order;
        $o->price_amount = $product["price"];
        $o->price_currency = 'BTC';
        $o->receive_currency = 'USD';
        $o->token = hash('md5', 'coingate'.rand());
        $o->title = $product["title"];
        $o->description = $product["body"];
        $o->status = 'processing';
        $o->user_id = auth()->user()->id;
        $o->save();

        /*$o = Order::create([
            'user_id' => $us,
            'price_amount' => $product["price"],
            'price_currency' => 'BTC',
            'receive_currency' => 'USD',
            'token' => hash('md5', 'coingate'.rand()),
            'title' => $product["title"],      
            'description' => $product["body"],
            'status' => 'bar'
            ]);*/

        $post_params = array(
            'order_id'          => $o->id,
            'price_amount'      => number_format((float) $product["price"], 8),
            'price_currency'    => $o->price_currency,
            'receive_currency'  => $o->receive_currency,
            'callback_url'      => 'http://localhost:81/coingate_callback',
            'cancel_url'        => 'http://localhost:81/failed',
            'success_url'       => 'http://localhost:81/',
            'title'             => $o->user_id,
            'description'       => $product["body"],
            'status'            => $o->status,
            'token'             => $o->token
        );

$order = \CoinGate\Merchant\Order::create($post_params);

if ($order) {

return redirect($order->payment_url);
        } else {
        return view('Pages.failed');
        }
    }

    public function orderWL($id, Request $request)
    {
        $product = Product::find($id);
        $o = Order::create([
            
            'price_amount' => $product["price"],
            'price_currency' => $request->currency,
            'receive_currency' => 'USD',
            'token' => hash('md5', 'coingate'.rand()),
            'title' => $product["title"],      
            'description' => $product["body"],
            'status' => 'Processing'
            ]);

        $post_params = array(
            'order_id'          => $o->id,
            'price_amount'      => number_format((float) $product["price"], 8),
            'price_currency'    => $o->price_currency,
            'receive_currency'  => $o->receive_currency,
            'callback_url'      => 'http://localhost:81/coingate_callback',
            'cancel_url'        => 'http://localhost:81/failed',
            'success_url'       => 'http://localhost:81/',
            'title'             => $product["title"].' '.$o->id,
            'description'       => $product["body"],
            'status'            => $o->status,
            'token'             => $o->token
        );

$order = \CoinGate\Merchant\Order::create($post_params);


    $curl = curl_init("https://api.coingate.com/v2/orders/{$order->id}/checkout");
            $headr = array('Authorization: Token Y1rgpvcV4Lma8snFw-2AYZgtHUbhv_JhxqgZNCEc');
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headr);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, count(array("pay_currency={$o->price_currency}")));
            curl_setopt($curl, CURLOPT_POSTFIELDS, "pay_currency={$o->price_currency}");
            $resp = curl_exec($curl);
            curl_close($curl);
            header("Location: " . json_decode($resp, true)["payment_url"]);
            die();
            redirect(json_decode($resp, true)["payment_url"]);
            
            
    #curl -H "Authorization: Token Y1rgpvcV4Lma8snFw-2AYZgtHUbhv_JhxqgZNCEc" -X POST -d "pay_currency=BTC" https://api.coingate.com/v2/orders/1928662/checkout

    }

    public function callback(Request $request) {
        $order = Order::where('order_id', $request->order_id)->first();
        $token = $request->input('token'); 
        echo $request->order_id;
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
                Order::where('order_id', $order->order_id)->update(['status'=> $status]);
            }
        }
    }

    public function getStatus(Request $request){
        $status = DB::table('orders')->where('order_id', $request->order_id)->value('status');    

        return view('Products.checkStatus')->with('status', $status);
    }

}
  
