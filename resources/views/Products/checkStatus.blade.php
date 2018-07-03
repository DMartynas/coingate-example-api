@extends('layouts.app')

@section('content')
<div class="container">
        <div class="jumbotron bg-light">
                <h1>Current status of your order: {{$status}}</h1>
        </div>
</div>
@endsection