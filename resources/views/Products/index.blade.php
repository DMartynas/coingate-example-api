@extends('layouts.app')

@section('content')
<div class="container">
        <div class="jumbotron bg-light">
                <h1>Catalog</h1>
                <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
              <hr>
        
              <div class="row justify-content-around">
    @if(count($products) > 0)

    @foreach ($products as $product)
    <div class="col-4 inlined rounded border ">
            <a href="/products/{{$product->id}}"><h3>{{$product->title}}</h3></a>
            <p><?php echo($product->body) ?></p>
            <p>Price: {{$product->price}}BTC</p>
            <div class="row justify-content-between">
            <div class="col-4"><small><p>Created at: {{$product->created_at}}</p></small></div>
            @if(!Auth::guest())
            <div class="col-4"><a href="{{ url('/products/order/' . $product->id)}}" class="btn btn-success" role="button" aria-pressed="true">Purchase</a></div>
            @if(Auth::user()->role_id ==3 )
            <div class="col-4"><form method="POST" action="{{ route('prod.destroy', [$product->id]) }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class = "btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button>
                </form>
            </div>
            @endif
            @endif
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