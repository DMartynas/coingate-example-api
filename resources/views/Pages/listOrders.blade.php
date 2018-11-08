@extends('layouts.app')

@section('content')
<div class="container">
        <div class="jumbotron bg-light">
            <h1>CoinGate Orders</h1>
            <table class="table">
                <thead>
                    <th scope="col">CG ID</th>
                    <th scope="col">ID</th>
                    <th scope="col">Status</th>
                    <th scope="col">Price</th>
                    <th scope="col">Receive Ammount</th>
                    <th scope="col">Created At</th>

                </thead>
            @foreach($orders->orders as &$o)
                <tbody>
                    <tr>
                        <td>{{$o->id}}</td>
                        <td>{{$o->order_id}}</td>
                        <td>{{$o->status}}</td>
                        <td> @if($o->price_currency == "USD") $@elseif ($o->price_currency == "GBP")£@endif{{$o->price_amount}}@if ($o->price_currency == "EUR") €@elseif ($o->price_currency != "USD" && $o->price_currency != "GBP"){{$o->price_currency}}@endif </td>
                        <td>@if($o->receive_currency == "USD") $@elseif ($o->receive_currency == "GBP")£@endif{{$o->receive_amount}}@if ($o->receive_currency == "EUR") €@elseif ($o->receive_currency != "USD" && $o->receive_currency != "GBP"){{$o->receive_currency}}@endif </td>
                        <td>{{substr($o->created_at, 0, -6)}}</td>
                    </tr>
                </tbody>
            @endforeach
            </table>
            <nav>
                    <ul class="pagination justify-content-center">
                        @if($orders->current_page == 1)
                            <li class="page-item disabled">
                                <a class="page-link" href="" tabindex="-1">Previous</a>
                            </li>
                        @else
                            <a class="page-link" href="http://localhost:81/list/{{$orders->current_page-1}}">Previous</a>
                        @endif

                        @for($i = 1; $i < $orders->total_pages; $i++)
                            @if($orders->current_page == $i) 
                                <li class="page-item active">
                                <a class="page-link" href="http://localhost:81/list/{{$i}}">{{$i}}</a>
                                </li>
                            @else 
                                <li class="page-item"><a class="page-link" href="http://localhost:81/list/{{$i}}">{{$i}}</a></li>
                            @endif
                        @endfor
                        @if($orders->total_pages == $orders->current_page)
                            <li class="page-item disabled">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        @else <a class="page-link" href="http://localhost:81/list/{{$orders->current_page+1}}">Next</a>
                        @endif
                      
                    </ul>
            </nav>
        </div>
</div>
@endsection

<!--["id"]=> int(1921015) ["status"]=> string(7) "expired" ["do_not_convert"]=> bool(false) ["price_currency"]=> string(3) "USD" 
["price_amount"]=> string(4) "50.0" ["lightning_network"]=> bool(false) ["receive_currency"]=> string(3) "BTC" 
["receive_amount"]=> string(0) "" ["created_at"]=> string(25) "2018-08-27T09:21:08+00:00" ["order_id"]=> string(0) ""-->