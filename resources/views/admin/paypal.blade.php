@extends('_layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center page-header">
                <h1>Paypal</h1>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Account</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Points</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($paypal as $code)
                        <tr>
                            <th scope="row" class="text-center">{{$code->txnid}}</th>
                            <td class="text-center">{{$code->id_account}}</td>
                            <td class="text-center">{{$code->price}}€</td>
                            <td class="text-center">{{$code->amount}}</td>
                            <td class="text-center">{{$code->status}}</td>
                            @if (Carbon::parse($code->created_at)->isToday())
                                <td class="text-center text-success">{{$code->created_at}}</td>
                            @else
                                <td class="text-center">{{$code->created_at}}</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Pagination -->
        <div class="row text-center">
            <div class="col col-md-12">
                {!!$paypal->render() !!}
            </div>
        </div>
    </div>
@stop
