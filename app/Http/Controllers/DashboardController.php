<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Order;
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $users = User::all();
        if($user->role_id == 3) return view('dashboard')->with('orders', Order::orderBy('order_id', 'desc')->paginate(10))->with('user', $user)->with('users', $users);
        return view('dashboard')->with('orders', $user->orders)->with('user', $user);
    }
}
