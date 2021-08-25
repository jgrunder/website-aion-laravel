@extends('_layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center page-header">
                <h1>Points's Shop</h1>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-center">Sender</th>
                        <th class="text-center">Receiver</th>
                        <th class="text-center">Points</th>
                        <th class="text-center">Reason</th>
                        <th class="text-center">Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($points as $point)
                        <tr>
                            <th scope="row" class="text-center">{{$point->sender_name}}</th>
                            <td class="text-center">{{$point->receiver_name}}</td>
                            <td class="text-center">{{$point->points}}</td>
                            <td class="text-center">{{$point->reason}}</td>
                            @if (Carbon::parse($point->created_at)->isToday())
                                <td class="text-center text-success">{{$point->created_at}}</td>
                            @else
                                <td class="text-center">{{$point->created_at}}</td>
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
                {!!$points->render() !!}
            </div>
        </div>
    </div>
@stop
