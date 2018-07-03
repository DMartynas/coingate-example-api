@extends('layouts.app')
@section('content')
<div class="container">
<div class="jumbotron bg-light">
        <h1>Your order was succesful!</h1>
        <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        {!! Form::open(['action' => 'ProductsController@getStatus', 'method' => 'POST']) !!}
        <div class="form-group">
            {{Form::label('orderid', 'Order ID')}}
            {{Form::text('order_id', '', ['class' => 'form-control'])}}
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-success'])}}
{!! Form::close() !!}
    </div>
    </div>
  </div>
@endsection