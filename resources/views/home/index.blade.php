@extends('_layouts.master')

@section('content')
<div class="container">
    <!-- LEFT CONTENT -->
    <div class="container_left">
      <!-- CALL TO ACTION -->
      @include('_modules.call_to_action')

      <!-- NEWS -->
      @include('_modules.news')
    </div>
    <!-- RIGHT SIDEBAR -->
    <div class="container_right">
      @include('_modules.right_sidebar')
    </div>
  </div>
@stop
