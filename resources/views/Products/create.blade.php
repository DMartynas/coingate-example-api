@extends('layouts.app')
@section('content')

<div class="container">

<div class="jumbotron bg-light">
        <h1>Create new mobile phone plan</h1>
        {!! Form::open(['action' => 'ProductsController@store', 'method' => 'POST']) !!}
        <div class="form-group">
            {{Form::label('planname', 'Plan Name')}}
            {{Form::text('planname', '', ['class' => 'form-control'])}}

            {{Form::label('description', 'Description')}}
            {{Form::textarea('description', '', ['id'=>'article-ckeditor', 'class' => 'form-control'])}}

            {{Form::label('price', 'Price')}}
            {{Form::text('price', '', ['class' => 'form-control'])}}
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-success'])}}
        {!! Form::close() !!}
    </div>
    </div>
    
  </div>
  

@endsection