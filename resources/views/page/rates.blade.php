@extends('_layouts.master')

@section('content')
<div class="container_single subscribe">
  <div class="container_single_top">
    <h1>{{ Lang::get('all.nav.rates') }}</h1>
  </div>
  <div class="container_single_body center">
    {!! $content !!}
  </div>
</div>
@stop
