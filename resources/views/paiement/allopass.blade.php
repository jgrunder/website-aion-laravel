@extends('_layouts.master')

@section('content')
    <div class="container_single">
        <div class="container_single_top">
            <h1>Allopass</h1>
        </div>
        <div class="container_single_body">
            <iframe width="100%" height="600" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" src="{!! Config::get('aion.allopass.url') !!}"></iframe>
        </div>
    </div>
@stop
