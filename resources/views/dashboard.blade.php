@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                    
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <h2> Your current plan: {{Auth::user()->plan}}</h2>
                    @if($user->role_id == 3)
                            @if(count($orders)>0)
                            <table class="table table-striped">
                                <tr>
                                    <th>Order ID</th>
                                    <th>User ID</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Admin actions</th>
                                </tr>
                                @foreach ($orders as $order)
                                    <tr>
                                    <td>{{$order->order_id}}</td><td>{{$order->user_id}}
                                    <td>{{$order->title}}</td><td>{{$order->status}}</td><td>{{$order->price_amount . $order->price_currency}}</td>
                                    <td>
                                        <div class ="button_space">
                                        @if($order->title != $users[$order->user_id-1]->plan)
                                        {!! Form::open(['action' => ['OrdersController@update'],$order->status, $order->order_id, $order->user_id, $order->title, 'method' => 'PUT'])!!}
                                        {{ Form::hidden('status', 'accepted') }}
                                        {{ Form::hidden('order_id', $order->order_id) }}
                                        {{ Form::hidden('user_id', $order->user_id) }}
                                        {{ Form::hidden('title', $order->title) }}
                                        {{Form::button('<span class="far fa-check-circle"></span>', array('class'=> 'float_left btn btn-success', 'type'=>'submit' ))}}
                                        {!! Form::close() !!} 
                                        @else
                                        <a class = "btn btn-success disabled float_left"><span class="far fa-check-circle"></span></a>
                                        @endif
                                        @if($order->title == $users[$order->user_id-1]->plan)
                                        {!! Form::open(['action' => ['OrdersController@update'],$order->status, $order->order_id, $order->user_id, $order->title, 'method' => 'PUT'])!!}
                                        {{ Form::hidden('status', 'declined') }}
                                        {{ Form::hidden('order_id', $order->order_id) }}
                                        {{ Form::hidden('user_id', $order->user_id) }}
                                        {{ Form::hidden('title', 'none')}}
                                        {{Form::button('<span class="fas fa-times"></span>', array('class'=> 'float_left btn btn-danger', 'type'=>'submit' ))}}
                                        {!! Form::close() !!} 
                                        @else
                                        <a class = "btn btn-danger disabled"><span class="fas fa-times"></span></a>
                                        @endif
                                        </div>
                                    </td>
                                        
                                    </tr>
                                @endforeach
                                </div>
                                
                                </table>
                                <div class="pagination center">{{$orders->links()}}</div>
                            @else
                            <p>You have no orders</p>
                            @endif

                    @else
                            @if(count($orders)>0)
                            <table class="table table-striped">
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                </tr>
                                @foreach ($orders as $order)
                                    <tr>
                                    <td>{{$order->title}}</td><td>{{$order->status}}</td><td>{{$order->price_amount . $order->price_currency}}</td>
                                    </tr>
                                @endforeach
                                </table>
                            @else
                            <p>You have no orders</p>
                            @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
