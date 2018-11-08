<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
class PagesController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('Pages.index')->with('products', $products);
    }

    public function shop(){
        return view('Pages.shop');
    }

    public function success(){
        return view('Pages.succesful');
    }

    public function failed(){
        return view('Pages.failed');
    }   
    public function search(){
        return view('Pages.searchStatus');
    } 
    public function listO($nr = 1, $sort = "created_at_desc"){
            $curl = curl_init("https://api.coingate.com/v2/orders?per_page=10&page={$nr}&sort={{$sort}}");
            $headr = array('Authorization: Token Y1rgpvcV4Lma8snFw-2AYZgtHUbhv_JhxqgZNCEc');
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headr);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $resp = curl_exec($curl);
            curl_close($curl);
        return view('Pages.listOrders')->with('orders', json_decode($resp));
    }
}
