@extends('layouts.app')

@section('content')
<div class="container">
        <div class="jumbotron bg-light">
                <h1>{{$product->title}}</h1>
                <p class="lead">{{$product->body}}</p>
              <hr>
            <small>Created at: {{$product->created_at}}</small>
        </div>
</div>
@endsection