@extends('layouts.app')

@section('content')
<div class="container">
        <div class="jumbotron bg-light">
                <h1>Catalog</h1>
                <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
              <hr>
        
              <div class="row justify-content-around">
    @if(count($orders) > 0)

    @foreach ($orders as $order)
    <div class="col-4 inlined rounded border ">
            <a href="/products/{{$product->id}}"><h3>{{$product->title}}</h3></a>
            <p>{{$product->body}}</p>
            <p>Price: {{$product->price}}BTC</p>
            <div class="row justify-content-between">
            <div class="col-4"><small><p>Created at: {{$product->created_at}}</p></small></div>
            
            <div class="col-4">@if(!Auth::guest())<a href="{{ url('/products/order/' . $product->id)}}" class="btn btn-success" role="button" aria-pressed="true">Purchase</a><a href="{{ url('/products/order/' . $product->id)}}" class="btn btn-success" role="button" aria-pressed="true">White label</a>@endif</div>
            </div>
            
          </div>   
        
        
    @endforeach
</div> 
    <div class="pagination center">{{$products->links()}}</div>  

    </div>
    @else
    <div>
        <p> No products found! </p>
    </div>
    @endif
            </div>
        </div>
    </div>
@endsection()