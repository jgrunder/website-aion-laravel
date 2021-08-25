@extends('_layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="jumbotron">
                <h1>GM's Dashboard</h1>
                <p>If you have a issue, contact : <a href="mailto:mathieu.letyrant@gmail.com">mathieu.letyrant@gmail.com</a></p>
            </div>
        </div>
        <!-- Status Servers -->
        <div class="row">

            <!-- Servers Status -->
            @foreach($serversStatus as $value)
                <div class="col col-md-4">
                @if ($value['status'])
                    <div class="alert alert-success text-center">
                        {{Lang::get('all.layout.status_of')}} {{$value['name']}} :
                        <span class="{{($value['status']) ? 'online' : 'offline'}}">
                            <strong>{{($value['status']) ? 'ON' : 'OFF'}}</strong>
                        </span>
                    </div>
                @else
                    <div class="alert alert-danger text-center">
                        {{Lang::get('all.layout.status_of')}} {{$value['name']}} :
                        <span class="{{($value['status']) ? 'online' : 'offline'}}">
                            <strong>{{($value['status']) ? 'ON' : 'OFF'}}</strong>
                        </span>
                    </div>
                @endif
                </div>
            @endforeach

        </div>
        <!-- Numbers -->
        <div class="row">
            <div class="col col-md-12 page-header text-center">
                <h1>Numbers</h1>
            </div>
        </div>
        <div class="row">
            <!-- Shop number -->
            <div class="col col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-shopping-cart"></i>
                            Purchase shop
                        </h3>
                    </div>
                    <div class="panel-body text-center">
                        <p>Today :</p>
                        <h2><strong>{{$shopHistoryToday}}</strong></h2>
                        <p>Total :</p>
                        <h2><strong>{{$shopHistoryTotal}}</strong></h2>
                    </div>
                </div>
            </div>
            <!-- Best items buy -->
            <div class="col col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-line-chart"></i>
                            Best sales
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table>
                            <thead>
                            <tr>
                                <th width="90%">Name</th>
                                <th style="text-align: center;">Sales</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($topItemsBuy as $index => $item)
                                <tr>
                                    <td width="90%" class="strong">{{$item->name}}</td>
                                    <td style="text-align: center;">{{$item->purchased}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- User subscribe Today -->
            <div class="col col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-users"></i>
                            Accounts
                        </h3>
                    </div>
                    <div class="panel-body text-center">
                        <p>Total :</p>
                        <h2><strong>{{$accountsCount}}</strong></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
