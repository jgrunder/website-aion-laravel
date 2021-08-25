@extends('_layouts.master')

@section('content')
    <div class="container_single subscribe">
        <div class="container_single_top">
            <h1>{{Lang::get('all.nav.donate')}}</h1>
        </div>
        <div class="container_single_body center">
            <a href="{{Route('allopass')}}" class="btn">Allopass</a>
            <a href="{{Route('paypal')}}" class="btn">Paypal</a>
        </div>
    </div>
@stop
