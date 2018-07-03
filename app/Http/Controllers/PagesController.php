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
}
