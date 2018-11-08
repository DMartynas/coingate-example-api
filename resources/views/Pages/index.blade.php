@extends('layouts.app')
@section('content')
<div class="container">
<div class="jumbotron bg-light">
        <h1>Welcome to the PotShop!</h1>
        <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        <p><a class="btn btn-lg btn-success" href="/products" role="button">Start shopping!</a></p>
      <hr>

      <div class="row marketing">
        @if(count($products) > 0)

        @for ($i = 0; $i <= 1; $i++)
        <div class="col-4 inlined rounded border ">
          <a href="/products/{{$products[$i]->id}}"><h3>{{$products[$i]->title}}</h3></a>
                <p><?php echo($products[$i]->body) ?></p>
                <p>Price: {{$products[$i]->price}}BTC</p>
                <div class="row justify-content-between">
                <div class="col-4"><small><p>Created at: {{$products[$i]->created_at}}</p></small></div>
                <div class="col-4"><a href="{{ url('/products/order/' . $products[$i]->id)}}" class="btn btn-success" role="button" aria-pressed="true">Purchase</a></div>
                </div>
              </div>   
            
            
        @endfor
        @else
        <div>
            <p> No products found! </p>
        </div>
        @endif
    </div>
    </div>
  </div>
@endsection