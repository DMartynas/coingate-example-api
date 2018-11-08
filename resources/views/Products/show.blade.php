@extends('layouts.app')

@section('content')
<div class="container">
        <div class="jumbotron bg-light">
                <h1>{{$product->title}}</h1>
                <p class="lead"><?php echo($product->body) ?></p>

        </div>
</div>
@endsection