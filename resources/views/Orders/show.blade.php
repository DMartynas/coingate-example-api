@extends('layouts.app')

@section('content')
<div class="container">
        <div class="jumbotron bg-light">
                <h1>{{$order->title}}</h1>
                <p class="lead">{{$order->body}}</p>
              <hr>
            <small>Created at: {{$product->created_at}}</small>
        </div>
</div>
@endsection