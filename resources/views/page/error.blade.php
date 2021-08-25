@extends('_layouts.master')

@section('content')
<div class="container_single subscribe">
  <div class="container_single_top">
    <h1>{{ Lang::get('all.nav.errors') }}</h1>
  </div>
  <div class="container_single_body">

    @if(Session::has('error'))
      <h2 class="error">{{ Session::get('error') }}</h2>
    @elseif(Session::has('success'))
      <h2>{{ Session::get('success') }}</h2>
    @endif

    <img src="/images/shugo.png" alt="Shugo" class="shugo">

    <div class="clear"></div>

  </div>
</div>
@stop
